-- ============================================
-- ProxySQL bootstrap: backends, usuarios, reglas y réplica
-- ============================================

-- 1) Backends (hostgroups): limpiar e insertar
DELETE FROM mysql_servers WHERE hostgroup_id IN (10,20);

INSERT INTO mysql_servers (hostgroup_id, hostname, port, comment) VALUES
  (10, 'db',    3306, 'Servidor principal (master)'),
  (20, 'slave', 3306, 'Servidor secundario (replica)');

LOAD MYSQL SERVERS TO RUNTIME;
SAVE MYSQL SERVERS TO DISK;

-- 1.1) Hostgroups de replicación (writer=10, reader=20)
DELETE FROM mysql_replication_hostgroups
WHERE writer_hostgroup=10 OR reader_hostgroup=20;

INSERT INTO mysql_replication_hostgroups
  (writer_hostgroup, reader_hostgroup, comment)
VALUES
  (10, 20, 'R/W split');

-- No hay LOAD/SAVE específico para replication_hostgroups; se persiste con SAVE SERVERS.

-- 2) Usuario de la app (en ProxySQL; NO crea el usuario en MySQL)
DELETE FROM mysql_users WHERE username='userSS';

INSERT INTO mysql_users
  (username, password, default_hostgroup, transaction_persistent, fast_forward)
VALUES
  ('userSS', 'pass', 10, 1, 0);

LOAD MYSQL USERS TO RUNTIME;
SAVE MYSQL USERS TO DISK;

-- 3) Reglas de enrutado
--    Claves:
--    - Usar match_digest (más robusto).
--    - Para CALL: multiplex=0 (sin conexión compartida) y flagOUT=1 (corta la cadena).
--    - Orden de evaluación por rule_id.

DELETE FROM mysql_query_rules WHERE rule_id IN (1,2,3,4);

-- 3.1) CALL de escritura (prefijo esc_) → MASTER (HG 10)
INSERT INTO mysql_query_rules
  (rule_id, active, match_digest, destination_hostgroup, apply, multiplex, flagOUT)
VALUES
  (1, 1, '^CALL\\s+esc_.*', 10, 1, 0, 1);

-- 3.2) CALL de lectura (prefijo lec_) → SLAVE (HG 20)
INSERT INTO mysql_query_rules
  (rule_id, active, match_digest, destination_hostgroup, apply, multiplex, flagOUT)
VALUES
  (2, 1, '^CALL\\s+lec_.*', 20, 1, 0, 1);

-- 3.3) TODOS los SELECT → SLAVE (HG 20)
INSERT INTO mysql_query_rules
  (rule_id, active, match_digest, destination_hostgroup, apply)
VALUES
  (3, 1, '^SELECT', 20, 1);

-- 3.4) DML (INSERT/UPDATE/DELETE/REPLACE) → MASTER (HG 10)
INSERT INTO mysql_query_rules
  (rule_id, active, match_digest, destination_hostgroup, apply)
VALUES
  (4, 1, '^(INSERT|UPDATE|DELETE|REPLACE)', 10, 1);

LOAD MYSQL QUERY RULES TO RUNTIME;
SAVE MYSQL QUERY RULES TO DISK;

-- 4) Variables recomendadas para sesiones/multiplexing (opcional pero útil)
--    Ajusta tiempos según tu app. Se aplican y persisten con LOAD/SAVE VARIABLES.
--    Nota: estos nombres son de global_variables; usa UPDATE.
UPDATE global_variables SET variable_value='0'
 WHERE variable_name='mysql-connection_delay_multiplex_ms';

UPDATE global_variables SET variable_value='30000'
 WHERE variable_name='mysql-session_idle_timeout';

UPDATE global_variables SET variable_value='0'
 WHERE variable_name='mysql-monitor_writer_is_also_reader';

LOAD MYSQL VARIABLES TO RUNTIME;
SAVE MYSQL VARIABLES TO DISK;

-- ============================================
-- Fin de bootstrap
-- ============================================
