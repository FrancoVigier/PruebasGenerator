<?php

namespace PruebasGenerator;

use PHPUnit\Framework\TestCase;
use PruebasGenerator\Preprocess\ProtoPregunta;
use PruebasGenerator\Preprocess\ProtoPrueba;
use PruebasGenerator\Preprocess\ProtoRespuesta;
use PruebasGenerator\Process\FinalPrueba;
use Symfony\Component\Yaml\Exception\ParseException;
use League\Pipeline\Pipeline;
use Symfony\Component\Yaml\Yaml;

class MainTest extends TestCase {

	public function testProcessrespuestas() {
		//por cada rawpregunta
		$respuestascorrectasraw = ["10", "200", "1000"];
		$respuestasincorrectasraw = ["20", "30", "50"];

		$respuestas = [(new ProtoRespuesta("10", true)), (new ProtoRespuesta("200", true)), (new ProtoRespuesta("1000", true)), (new ProtoRespuesta("20", false)), (new ProtoRespuesta("30", false)), (new ProtoRespuesta("50", false))];

		$objmain = new Main();

		$respuestasb = $objmain->processRespuestas($respuestascorrectasraw, $respuestasincorrectasraw);

		$this->assertEquals($respuestas, $respuestasb);

	}

	public function testProcesspregunta() {
		$pregunt = array(
			"descripcion" => "preguntauno",
			"respuestas_correctas" => ["10", "200", "1000"],
			"respuestas_incorrectas" => ["20", "30", "50"],
			"ocultar_opcion_todas_las_anteriores" => false,
			"ocultas_opcion_ninguna_de_las_anteriores" => false,
			"texto_todas_las_anteriores" => "Todas",
			"texto_ninguna_de_las_anteriores" => "Ninguna",
			$isAllCorrect = false,
			$isNoCorrect = false
		);

		$objmain = new Main();

		$protopreguno = $objmain->processPregunta($pregunt);

		$protopregdos = new ProtoPregunta ("preguntauno", [(new ProtoRespuesta("10", true)), (new ProtoRespuesta("200", true)), (new ProtoRespuesta("1000", true)), (new ProtoRespuesta("20", false)), (new ProtoRespuesta("30", false)), (new ProtoRespuesta("50", false))], false, false, "Todas", "Ninguna", false, false);

		$this->assertEquals($protopreguno, $protopregdos);


		$pregunt = array(
			"descripcion" => "preguntados",
			"respuestas_correctas" => ["10", "200", "1000"],
			"respuestas_incorrectas" => ["20", "30", "50"],
			"ocultar_opcion_todas_las_anteriores" => true,
			"ocultas_opcion_ninguna_de_las_anteriores" => true,
			"texto_todas_las_anteriores" => "Todas",
			"texto_ninguna_de_las_anteriores" => "Ninguna",
			$isAllCorrect = false,
			$isNoCorrect = false
		);

		$protopreguno = $objmain->processPregunta($pregunt);

		$protopregdos = new ProtoPregunta ("preguntados", [(new ProtoRespuesta("10", true)), (new ProtoRespuesta("200", true)), (new ProtoRespuesta("1000", true)), (new ProtoRespuesta("20", false)), (new ProtoRespuesta("30", false)), (new ProtoRespuesta("50", false))], true, true, "Todas", "Ninguna", false, false);

		$this->assertEquals($protopreguno, $protopregdos);

		$pregunt = array(
			"descripcion" => "preguntatres",
			"respuestas_correctas" => ["10", "200", "1000"],
			"respuestas_incorrectas" => ["20", "30", "50"],
			"ocultar_opcion_todas_las_anteriores" => false,
			"ocultas_opcion_ninguna_de_las_anteriores" => true,
			"texto_todas_las_anteriores" => "",
			"texto_ninguna_de_las_anteriores" => "",
			$isAllCorrect = false,
			$isNoCorrect = false
		);
		$protopreguno = $objmain->processPregunta($pregunt);

		$protopregdos = new ProtoPregunta ("preguntatres", [(new ProtoRespuesta("10", true)), (new ProtoRespuesta("200", true)), (new ProtoRespuesta("1000", true)), (new ProtoRespuesta("20", false)), (new ProtoRespuesta("30", false)), (new ProtoRespuesta("50", false))], false, true, "", "", false, false);

		$this->assertEquals($protopreguno, $protopregdos);

		$pregunt = array(
			"descripcion" => "preguntacuatro",
			"respuestas_correctas" => ["10", "200", "1000"],
			"respuestas_incorrectas" => ["20", "30", "50"],
			"ocultar_opcion_todas_las_anteriores" => true,
			"ocultas_opcion_ninguna_de_las_anteriores" => false,
			"texto_todas_las_anteriores" => "",
			"texto_ninguna_de_las_anteriores" => "",
			$isAllCorrect = false,
			$isNoCorrect = false
		);

		$protopreguno = $objmain->processPregunta($pregunt);

		$protopregdos = new ProtoPregunta ("preguntacuatro", [(new ProtoRespuesta("10", true)), (new ProtoRespuesta("200", true)), (new ProtoRespuesta("1000", true)), (new ProtoRespuesta("20", false)), (new ProtoRespuesta("30", false)), (new ProtoRespuesta("50", false))], true, false, "", "", false, false);

		$this->assertEquals($protopreguno, $protopregdos);

		$pregunt = array(
			"descripcion" => "preguntacinco",
			"respuestas_correctas" => ["10", "200", "1000"],
			"respuestas_incorrectas" => ["20", "30", "50"],
			"ocultar_opcion_todas_las_anteriores" => true,
			"ocultas_opcion_ninguna_de_las_anteriores" => true,
			"texto_todas_las_anteriores" => "Todas",
			"texto_ninguna_de_las_anteriores" => "Ninguna",
			$isAllCorrect = false,
			$isNoCorrect = false
		);

		$protopreguno = $objmain->processPregunta($pregunt);

		$protopregdos = new ProtoPregunta ("preguntacinco", [(new ProtoRespuesta("10", true)), (new ProtoRespuesta("200", true)), (new ProtoRespuesta("1000", true)), (new ProtoRespuesta("20", false)), (new ProtoRespuesta("30", false)), (new ProtoRespuesta("50", false))], true, true, "Todas", "Ninguna", false, false);

		$this->assertEquals($protopreguno, $protopregdos);

		$pregunt = array(
			"descripcion" => "preguntaseis",
			"respuestas_correctas" => ["10", "200", "1000"],
			"respuestas_incorrectas" => ["20", "30", "50"],
			"ocultar_opcion_todas_las_anteriores" => true,
			"ocultas_opcion_ninguna_de_las_anteriores" => false,
			"texto_todas_las_anteriores" => "Todas",
			"texto_ninguna_de_las_anteriores" => "",
			$isAllCorrect = false,
			$isNoCorrect = false
		);

		$protopreguno = $objmain->processPregunta($pregunt);

		$protopregdos = new ProtoPregunta ("preguntaseis", [(new ProtoRespuesta("10", true)), (new ProtoRespuesta("200", true)), (new ProtoRespuesta("1000", true)), (new ProtoRespuesta("20", false)), (new ProtoRespuesta("30", false)), (new ProtoRespuesta("50", false))], true, false, "Todas", "", false, false);

		$this->assertEquals($protopreguno, $protopregdos);

		$pregunt = array(
			"descripcion" => "preguntasiete",
			"respuestas_correctas" => ["10", "200", "1000"],
			"respuestas_incorrectas" => ["20", "30", "50"],
			"ocultar_opcion_todas_las_anteriores" => true,
			"ocultas_opcion_ninguna_de_las_anteriores" => false,
			"texto_todas_las_anteriores" => "",
			"texto_ninguna_de_las_anteriores" => "Ninguna",
			$isAllCorrect = false,
			$isNoCorrect = false
		);

		$protopreguno = $objmain->processPregunta($pregunt);

		$protopregdos = new ProtoPregunta ("preguntasiete", [(new ProtoRespuesta("10", true)), (new ProtoRespuesta("200", true)), (new ProtoRespuesta("1000", true)), (new ProtoRespuesta("20", false)), (new ProtoRespuesta("30", false)), (new ProtoRespuesta("50", false))], true, false, "", "Ninguna", false, false);

		$this->assertEquals($protopreguno, $protopregdos);

		$pregunt = array(
			"descripcion" => "preguntaocho",
			"respuestas_correctas" => ["10", "200", "1000"],
			"respuestas_incorrectas" => ["20", "30", "50"],
			"ocultar_opcion_todas_las_anteriores" => true,
			"ocultas_opcion_ninguna_de_las_anteriores" => false,
			"texto_todas_las_anteriores" => "Todas",
			"texto_ninguna_de_las_anteriores" => "Ninguna",
			$isAllCorrect = false,
			$isNoCorrect = false
		);

		$protopreguno = $objmain->processPregunta($pregunt);

		$protopregdos = new ProtoPregunta ("preguntaocho", [(new ProtoRespuesta("10", true)), (new ProtoRespuesta("200", true)), (new ProtoRespuesta("1000", true)), (new ProtoRespuesta("20", false)), (new ProtoRespuesta("30", false)), (new ProtoRespuesta("50", false))], true, false, "Todas", "Ninguna", false, false);

		$this->assertEquals($protopreguno, $protopregdos);
	}

	/*
	public function testProcessrawtext(){

	$objmain = new Main();
		   //$ymlFile = $_SERVER['DOCUMENT_ROOT'] . "/preguntas.yml";

   $protopruebauno = $objmain->generatePrueba(1);

	$protopreguno = new ProtoPregunta("El término pixel hace referencia a",[(new ProtoRespuesta("La unidad mínima de información de una imagen.", true)),(new ProtoRespuesta("La longitud de la diagonal de una imagen en pulgadas.", false)),(new ProtoRespuesta("La cantidad de puntos por pulgada.", false)),(new ProtoRespuesta("La cantidad de colores de un punto.", false))],true);
	$protopregdos = new ProtoPregunta( "Para las imágenes vectoriales se cumple que", [(new ProtoRespuesta("Poseen un número fijo de píxeles.", false)),(new ProtoRespuesta("Son creadas por los escaners y las cámaras digitales.", false)),(new ProtoRespuesta("Pueden perder detalle y verse pixeladas cuando se amplían.", false)),(new ProtoRespuesta("A cada píxel se le asigna una ubicación y un valor de color específico.", false))]);



	 $preguntasprotouno = $protopruebauno[0]->pregunta();

	 $this->assertEquals(true,in_array ($protopreguno,$preguntasprotouno));
	 $this->assertEquals(true,in_array ($protopregdos,$preguntasprotouno));
	}
	*/

}
