<?php
use App\Http\Controllers\BotManController;

$botman = resolve('botman');

//Saludo inicial.
$botman->hears('/start', function ($bot) {
	$nombres = $bot->getUser()->getFirstName() ?: "desconocido";
	$bot->reply('Hola ' . $nombres . ', bienvenido al bot SimpleQuizzes!');
});

//Comandos diseñados de ayuda para el boot.
$botman->hears('/ayuda', function ($bot) {
	$ayuda = ['/ayuda' => 'Mostrar este mensaje de ayuda',
          	'acerca de|acerca' => 'Ver la información quien desarrollo este lindo bot',
          	'listar quizzes|listar' => 'Listar los cuestionarios disponibles',
          	'iniciar quiz <id>' => 'Iniciar la solución de un cuestionario',
          	'ver puntajes|puntajes' => 'Ver los últimos puntajes',
          	'borrar mis datos|borrar' => 'Borrar mis datos del sistema'];
    
	$bot->reply("Los comandos disponibles son:");

	foreach($ayuda as $key=>$value)
	{
    		$bot->reply($key . ": " . $value);
	}
});

//Opción acerca de.
$botman->hears('acerca de|acerca', function ($bot) 
{
	$msj = "Este bot de charla fue desarrollado por:\n".
       	 "Jorge I. Meza <jorge.meza@ucaldas.edu.co>\n".
       	 "Durante las Jornadas de Ingeniería de 2018\n".
       	 "de la Universidad de Caldas.";

	$bot->reply($msj);
});

//Listar los quices disponibles.
$botman->hears('listar quizzes|listar', function ($bot) 
{
	$quizzes = \App\Quiz::orderby('titulo', 'asc')->get();

	foreach($quizzes as $quiz)
	{
    		$bot->reply($quiz->id."- ".$quiz->titulo);
	}

	if(count($quizzes) == 0)
    		$bot->reply("Ups, no hay cuestionarios para mostrar.");
});

//Iniciar un quiz en especifico.
$botman->hears('iniciar quiz {id}', function ($bot, $id) 
{
	$bot->startConversation(
		new \App\Conversations\RealizarQuizConversacion($id));
})->stopsConversation();





//Comportamiento por defecto.
$botman->fallback(function ($bot) {
	$bot->reply("No entiendo que quieres decir, vuelve a intentarlo.");
});
