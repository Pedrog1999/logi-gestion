hola q tal

git clone URL del repo 

les dejé el .env.example, se paran en tpfinal y cp .env.example .env (deja de ser .example)

cd tpfinal (pwd para comprobar) y hacer el docker compose up --build ahi mismo, en la raiz

si tienen algun puerto ocupado cambiarlo desde el .env , NO desde el .yml xfa 

si no cambian los puertos  probar:
- Front: http://localhost:3000
- Back: http://localhost:8000
- phpMyAdmin: http://localhost:8080 (user: root, pass: la del .env)


SI llegan a cambiar algo del .env, hagan docker compose down y vuelvan a levantar la imagen con el up --build


------- 0 -------

docker compose exec back php spark migrate

migrations de user hecha para probar, funciona y ya está en master, con ese comando la corren dentro del contenedor