-- Seed data for development/testing. Idempotent inserts.

-- Users
INSERT INTO usuarios (usu_mail, usu_pass, usu_nombre, usu_nivel, usu_vercod, usu_activo, usu_status, usu_change)
SELECT 'admin@mail.test', MD5('admin123'), 'Administrador', 'admin', 'seed-admin', 1, 0, 0
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE usu_mail = 'admin@mail.test');

INSERT INTO usuarios (usu_mail, usu_pass, usu_nombre, usu_nivel, usu_vercod, usu_activo, usu_status, usu_change)
SELECT 'prof@mail.test', MD5('prof123'), 'Profesor Uno', 'profesor', 'seed-prof', 1, 0, 0
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE usu_mail = 'prof@mail.test');

INSERT INTO usuarios (usu_mail, usu_pass, usu_nombre, usu_nivel, usu_vercod, usu_activo, usu_status, usu_change)
SELECT 'alum@mail.test', MD5('alum123'), 'Alumno Uno', 'estudiante', 'seed-alum', 1, 0, 0
WHERE NOT EXISTS (SELECT 1 FROM usuarios WHERE usu_mail = 'alum@mail.test');

-- Professor profile (assumes autoincrement if not provided). If id must be fixed, use 1.
INSERT INTO profesor (id_profes, usu_mail, pro_biografia, pro_foto)
SELECT 1, 'prof@mail.test', 'Docente de ejemplo para entorno de pruebas.', NULL
WHERE NOT EXISTS (SELECT 1 FROM profesor WHERE id_profes = 1);

-- Courses (use simple codes; multimedia files may be missing during dev)
INSERT INTO curso (cur_codigo, id_profes, cur_nombre, cur_descri, cur_costo, cur_img, cur_video)
SELECT 'CURS001', 1, 'Curso de Prueba Gratis', 'Introducción de prueba sin costo.', 0, 'jpg', 'mp4'
WHERE NOT EXISTS (SELECT 1 FROM curso WHERE cur_codigo = 'CURS001');

INSERT INTO curso (cur_codigo, id_profes, cur_nombre, cur_descri, cur_costo, cur_img, cur_video)
SELECT 'CURS002', 1, 'Curso de Prueba Pago', 'Curso de prueba con costo simbólico.', 10, 'jpg', 'mp4'
WHERE NOT EXISTS (SELECT 1 FROM curso WHERE cur_codigo = 'CURS002');

-- Optional enrollment for the student
INSERT INTO matricula (cur_codigo, usu_mail, mat_fecha)
SELECT 'CURS001', 'alum@mail.test', CURRENT_DATE()
WHERE NOT EXISTS (
  SELECT 1 FROM matricula WHERE cur_codigo = 'CURS001' AND usu_mail = 'alum@mail.test'
);
