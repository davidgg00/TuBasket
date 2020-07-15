# TuBasket

TuBasket es una aplicación creada para el proyecto final de Grado Superior de Desarrollo de Aplicaciones Web. <br>
Esta aplicación web te permite crear tus propias ligas
de baloncesto y administrarlas a tu gusto. Podrás llevar la clasificación de los equipos automáticamente,
ver los resultados de todos los equipos, ver tus estadísticas individuales entre otras muchas funcionalidades.

### Objetivo
El objetivo general es que cualquier persona si quiere organizar una liga de baloncesto que se va a jugar en la vida real,
pueda crearla añadiendo los equipos y jugadores y así poder tener un mejor
análisis de las estadísticas, acceder a la clasificación, ver la media de puntos por partidos de un jugador etc...

### Funciones generales

##### Crear cuenta administrador desde la plataforma.
A la hora de registrarse en la plataforma tendrás una lista desplegable para elegir que tipo
de cuenta vas a crear.
##### Crear ligas con la cuenta administrador.
Una vez que hayas iniciado sesión con la cuenta administrador tendrás un panel con
varias opciones y una opción será esta.
##### Añadir (mínimo 6, máximo 10), editar o echar equipos a una
liga con la cuenta administrador.
Una vez dentro de la liga habrá una pestaña de gestión de equipos que te llevará a una
vista en el que hay un CRUD con los equipos
##### Crear cuenta entrenador o jugador a través de la plataforma.
A la hora de registrarse en la plataforma tendrás una lista desplegable para elegir que tipo
de cuenta vas a crear y si eliges entrenador o jugador aparecerá automáticamente en el
registro los campos de las credenciales de la liga (nombre y contraseña)

##### Solicitar unirse a un equipo por parte del jugador o entrenador
Una vez que te has registrado tendrás que iniciar sesión y deberás de elegir
el equipo al que vas a pertenecer en la liga, para ello te aparecerán todos
los equipos disponibles (de tu liga) y tendrás una opción en cada equipo de
“solicitar unirse”.
##### Confirmar al jugador o entrenador en la plataforma.
El administrador tendrá un apartado donde estarán los usuarios registrados
pendientes de acceder a la plataforma y con que equipo. El podrá aceptar o
denegar el acceso. Si se deniega se borrará la cuenta del jugador/entrenador.
##### Generar un calendario de liga con las fechas de cada partido y horas.
Para generar el calendario de liga debe de haber un mínimo de equipos (8) y un máximo
(10). Si no hay ese mínimo o se sobrepasa el máximo el administrador no tendrá la opción
de generar el calendario de liga.

##### Introducir los datos de los partidos y subirlos a la plataforma(admin)
Una vez que se haya jugado algún partido el administrador podrá subir los
datos del partido a la plataforma, tendrá que ir a la pestaña partidos,
seleccionar el partido a rellenar y habrá una interfaz para introducir los
datos del partido.
##### El usuario y entrenador recibirá una notificación de que los datos del partido se han subido.
Recibirá un correo en el que se el informará de que se han subido los
datos del partido
##### Consultar los datos de los partidos
Una vez dentro de la plataforma en la pestaña calendario si se han subido
los datos a la plataforma aparecerá el resultado y si clickas en él
aparecerá los datos del partido y tus estadísticas individuales
##### Fichar jugadores para el equipo con la cuenta entrenador
El entrenador tendrá una opción para ver las plantillas de los equipos y
tendrá una opción para solicitar un fichaje de un jugador, para ello el
entrenador tendrá que ofrecer un jugador de su equipo para realizar el
intercambio
##### Notificar si un jugador se lesiona (entrenador)
El entrenador tendrá que notificar si tiene en su plantilla algún lesionado para
que los demás entrenadores puedan verlo y plantear mejor el partido.

### Función según usuario

#### Administrador:
-Crear ligas <br>
-Añadir, editar o borrar equipos de la liga <br>
-Aceptar a Jugadores y Entrenadores que soliciten unirse a la liga <br>
-Decidir cuando se genera la liga <br>
-Elegir fecha y hora de cada partido <br>
-Insertar las estadísticas de los partidos <br>

#### Jugador:
-Solicitar unirse a un equipo de la liga (nada más registrarse). <br>
-No podrá acceder a la plataforma hasta que el administrador le acepte. <br>
-Podrá ver el calendario de liga. <br>
-Podrá ver sus estadísticas individuales de cada partido y la media. <br>
-Recibirá notificación cuando estén los datos de los partidos subidos. <br>

#### Entrenador:
-Solicitar unirse a un equipo de la liga (nada más registrarse). <br>
-No podrá acceder a la plataforma hasta que el administrador le acepte. <br>
-Podrá ver el calendario de liga. <br>
-Podrá ver las estadísticas de todos sus jugadores. <br>
-Tiene la posibilidad de fichar a un jugador ofreciendole él un jugador suyo (trueque). <br>
-Notificar si tiene algun jugador lesionado, especificiar quien y hasta que fecha. <br>
-Al acceder a un partido no disputado puede ver la plantilla del otro equipo y ver si hay algún jugador lesionado. <br>
