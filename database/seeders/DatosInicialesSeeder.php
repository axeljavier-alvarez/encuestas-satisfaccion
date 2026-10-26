<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class DatosInicialesSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([EscalasSeeder::class]);

        DB::transaction(function (): void {
            $this->crearPlantillas();
            $this->crearBancoPreguntas();
        });
    }

    private function crearBancoPreguntas(): void
    {
        // Datos originales del banco, adaptados a tipos múltiples por pregunta.
        $banco = json_decode(<<<'JSON'
[
  {
    "codigo": "REC-01",
    "factor": "Recomendación",
    "tema": "Probabilidad de recomendar",
    "texto": "En una escala de 0 a 10, donde 0 es nada probable y 10 es extremadamente probable, ¿qué tan probable es que recomiende a otra persona {referente}?",
    "obligatoria": true,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "ATR-01",
    "factor": "Atribución institucional",
    "tema": "Reconocimiento de responsables",
    "texto": "¿A quién o a quiénes atribuye la realización de {referente}?",
    "obligatoria": true,
    "tipos": [
      {
        "nombre": "Selección múltiple",
        "opciones": [
          {
            "valor": "muni",
            "etiqueta": "Municipalidad de Guatemala"
          },
          {
            "valor": "alcalde",
            "etiqueta": "Alcalde Ricardo Quiñónez"
          },
          {
            "valor": "auxiliar",
            "etiqueta": "Alcaldía Auxiliar"
          },
          {
            "valor": "personal",
            "etiqueta": "Dirección, programa o personal municipal"
          },
          {
            "valor": "otro",
            "etiqueta": "Otra persona o institución",
            "habilita_texto": true,
            "etiqueta_texto_adicional": "Especifique su respuesta"
          },
          {
            "valor": "no_sabe",
            "etiqueta": "No sabe",
            "es_excluyente": true
          }
        ]
      },
      {
        "nombre": "Texto abierto",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "DIF-01",
    "factor": "Difusión y acceso",
    "tema": "Primer canal de conocimiento",
    "texto": "¿Por qué medio se enteró por primera vez de este servicio o actividad?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Selección única",
        "opciones": [
          {
            "valor": "redes",
            "etiqueta": "Redes sociales",
            "habilita_texto": true,
            "etiqueta_texto_adicional": "¿En qué red social se enteró?"
          },
          {
            "valor": "auxiliar",
            "etiqueta": "Alcaldía Auxiliar"
          },
          {
            "valor": "personal",
            "etiqueta": "Personal municipal"
          },
          {
            "valor": "impreso",
            "etiqueta": "Volantes, afiches o carteles"
          },
          {
            "valor": "referido",
            "etiqueta": "Familiar, amigo o vecino"
          },
          {
            "valor": "medios",
            "etiqueta": "Radio, televisión o prensa"
          },
          {
            "valor": "whatsapp",
            "etiqueta": "Grupo de WhatsApp"
          },
          {
            "valor": "paso",
            "etiqueta": "Pasaba por el lugar"
          },
          {
            "valor": "visita",
            "etiqueta": "El equipo municipal llegó a mi comunidad o actividad"
          },
          {
            "valor": "otro",
            "etiqueta": "Otro medio",
            "habilita_texto": true,
            "etiqueta_texto_adicional": "Especifique su respuesta"
          },
          {
            "valor": "no_recuerda",
            "etiqueta": "No recuerda"
          }
        ]
      }
    ]
  },
  {
    "codigo": "DIF-02",
    "factor": "Difusión y acceso",
    "tema": "Conjunto de canales de conocimiento",
    "texto": "¿Por cuáles medios se enteró de este servicio o actividad?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Selección múltiple",
        "opciones": [
          {
            "valor": "redes",
            "etiqueta": "Redes sociales",
            "habilita_texto": true,
            "etiqueta_texto_adicional": "¿En qué red social se enteró?"
          },
          {
            "valor": "auxiliar",
            "etiqueta": "Alcaldía Auxiliar"
          },
          {
            "valor": "personal",
            "etiqueta": "Personal municipal"
          },
          {
            "valor": "impreso",
            "etiqueta": "Volantes, afiches o carteles"
          },
          {
            "valor": "referido",
            "etiqueta": "Familiar, amigo o vecino"
          },
          {
            "valor": "medios",
            "etiqueta": "Radio, televisión o prensa"
          },
          {
            "valor": "whatsapp",
            "etiqueta": "Grupo de WhatsApp"
          },
          {
            "valor": "paso",
            "etiqueta": "Pasaba por el lugar"
          },
          {
            "valor": "visita",
            "etiqueta": "El equipo municipal llegó a mi comunidad o actividad"
          },
          {
            "valor": "otro",
            "etiqueta": "Otro medio",
            "habilita_texto": true,
            "etiqueta_texto_adicional": "Especifique su respuesta"
          },
          {
            "valor": "no_recuerda",
            "etiqueta": "No recuerda",
            "es_excluyente": true
          }
        ]
      }
    ]
  },
  {
    "codigo": "DIF-03",
    "factor": "Difusión y acceso",
    "tema": "Facilidad de acceso",
    "texto": "¿Qué tan fácil le resultó acceder a este servicio o actividad?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "VIN-01",
    "factor": "Vinculación municipal",
    "tema": "Contacto con canales municipales",
    "texto": "¿Ha tenido contacto con la Alcaldía Auxiliar, el alcalde auxiliar o un promotor municipal de su zona?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Selección única",
        "opciones": [
          {
            "valor": "si",
            "etiqueta": "Sí"
          },
          {
            "valor": "no",
            "etiqueta": "No"
          },
          {
            "valor": "no_recuerda",
            "etiqueta": "No recuerda"
          }
        ]
      }
    ]
  },
  {
    "codigo": "VIN-02",
    "factor": "Vinculación municipal",
    "tema": "Experiencia del contacto municipal",
    "texto": "¿Cómo califica la atención recibida en ese contacto con la Alcaldía Auxiliar, el alcalde auxiliar o el promotor municipal?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "ATN-01",
    "factor": "Atención y acompañamiento",
    "tema": "Trato amable y respetuoso",
    "texto": "¿Cómo califica el trato recibido del personal?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "ATN-02",
    "factor": "Atención y acompañamiento",
    "tema": "Comunicación y seguimiento",
    "texto": "¿Cómo califica la comunicación del personal con usted durante la atención o seguimiento?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "ATN-03",
    "factor": "Atención y acompañamiento",
    "tema": "Resolución de dudas",
    "texto": "¿Cómo califica el apoyo del personal para resolver sus dudas?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "ATN-04",
    "factor": "Atención y acompañamiento",
    "tema": "Apoyo en la participación",
    "texto": "¿Cómo califica el apoyo del personal para participar en la actividad?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "ATN-05",
    "factor": "Atención y acompañamiento",
    "tema": "Puntualidad del personal",
    "texto": "¿Cómo califica la puntualidad del personal?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "ATN-06",
    "factor": "Atención y acompañamiento",
    "tema": "Presentación del personal",
    "texto": "¿Cómo califica la presentación personal de quien le atendió?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "ATN-07",
    "factor": "Atención y acompañamiento",
    "tema": "Servicios municipales de apoyo",
    "texto": "¿Qué tan útiles le resultaron los servicios de apoyo durante la actividad?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "ATN-08",
    "factor": "Atención y acompañamiento",
    "tema": "Disponibilidad de acompañamiento",
    "texto": "¿Contó con acompañamiento de un guía o del personal de apoyo cuando lo necesitó?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Selección única",
        "opciones": [
          {
            "valor": "si",
            "etiqueta": "Sí"
          },
          {
            "valor": "no",
            "etiqueta": "No"
          },
          {
            "valor": "no_necesite",
            "etiqueta": "No lo necesité"
          }
        ]
      }
    ]
  },
  {
    "codigo": "CAL-01",
    "factor": "Calidad del servicio o contenido",
    "tema": "Satisfacción con la experiencia",
    "texto": "¿Qué tan satisfecho quedó con este servicio o actividad?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CAL-02",
    "factor": "Calidad del servicio o contenido",
    "tema": "Descripción de la experiencia",
    "texto": "¿Cómo describiría su experiencia en este servicio o actividad?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Texto abierto",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CAL-03",
    "factor": "Calidad del servicio o contenido",
    "tema": "Capacidad técnica del personal",
    "texto": "¿Cómo califica la capacidad del personal para prestar este servicio o desarrollar esta actividad?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CAL-04",
    "factor": "Calidad del servicio o contenido",
    "tema": "Claridad de enseñanza o explicación",
    "texto": "¿Cómo califica la claridad de las explicaciones recibidas?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CAL-05",
    "factor": "Calidad del servicio o contenido",
    "tema": "Calidad del contenido",
    "texto": "¿Cómo califica el contenido de esta actividad?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CAL-06",
    "factor": "Calidad del servicio o contenido",
    "tema": "Desarrollo de las actividades",
    "texto": "¿Cómo califica el desarrollo de las actividades en las que participó?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CAL-07",
    "factor": "Calidad del servicio o contenido",
    "tema": "Calidad de la atención especializada",
    "texto": "¿Cómo califica la calidad del servicio especializado recibido?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CAL-08",
    "factor": "Calidad del servicio o contenido",
    "tema": "Calidad de la función cultural",
    "texto": "¿Cómo califica la calidad de la presentación artística?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CAL-09",
    "factor": "Calidad del servicio o contenido",
    "tema": "Establecimientos visitados",
    "texto": "¿Cómo califica la experiencia en los establecimientos visitados durante el recorrido?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CAL-10",
    "factor": "Calidad del servicio o contenido",
    "tema": "Repertorio o programación artística",
    "texto": "¿Cómo califica el repertorio o la programación artística presentada?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-01",
    "factor": "Condiciones de prestación",
    "tema": "Duración",
    "texto": "¿Cómo considera la duración de este servicio o actividad?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Selección única",
        "opciones": [
          {
            "valor": "corta",
            "etiqueta": "Insuficiente"
          },
          {
            "valor": "adecuada",
            "etiqueta": "Adecuada"
          },
          {
            "valor": "larga",
            "etiqueta": "Excesiva"
          },
          {
            "valor": "no_sabe",
            "etiqueta": "No sabe"
          }
        ]
      }
    ]
  },
  {
    "codigo": "CON-02",
    "factor": "Condiciones de prestación",
    "tema": "Horario",
    "texto": "¿Qué tan adecuado le resultó el horario?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-03",
    "factor": "Condiciones de prestación",
    "tema": "Ubicación",
    "texto": "¿Qué tan accesible le resultó la ubicación?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-04",
    "factor": "Condiciones de prestación",
    "tema": "Instalaciones",
    "texto": "¿Cómo califica las instalaciones utilizadas?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-05",
    "factor": "Condiciones de prestación",
    "tema": "Limpieza e higiene",
    "texto": "¿Cómo califica la limpieza del lugar o de los establecimientos utilizados?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-06",
    "factor": "Condiciones de prestación",
    "tema": "Mobiliario",
    "texto": "¿Cómo califica el mobiliario utilizado?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-07",
    "factor": "Condiciones de prestación",
    "tema": "Disponibilidad de materiales",
    "texto": "¿Qué tan suficiente fue la cantidad de materiales disponibles?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-08",
    "factor": "Condiciones de prestación",
    "tema": "Adecuación de materiales a la edad",
    "texto": "¿Qué tan adecuados fueron los materiales para la edad de quienes participaron?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-09",
    "factor": "Condiciones de prestación",
    "tema": "Utilidad de materiales de apoyo",
    "texto": "¿Qué tan útiles fueron los materiales para realizar las actividades o aprender?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-10",
    "factor": "Condiciones de prestación",
    "tema": "Equipo utilizado",
    "texto": "¿Cómo califica el equipo utilizado en la actividad?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-11",
    "factor": "Condiciones de prestación",
    "tema": "Sonido del evento",
    "texto": "¿Cómo califica el sonido durante el evento?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-12",
    "factor": "Condiciones de prestación",
    "tema": "Escenario y montaje",
    "texto": "¿Cómo califica el escenario o montaje utilizado?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-13",
    "factor": "Condiciones de prestación",
    "tema": "Iluminación",
    "texto": "¿Cómo califica la iluminación del espacio?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-14",
    "factor": "Condiciones de prestación",
    "tema": "Cantidad de asientos",
    "texto": "¿Qué tan suficiente fue la cantidad de asientos disponibles?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-15",
    "factor": "Condiciones de prestación",
    "tema": "Conexión virtual",
    "texto": "¿Cómo califica la estabilidad de la conexión durante la actividad virtual?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-16",
    "factor": "Condiciones de prestación",
    "tema": "Audio virtual",
    "texto": "¿Cómo califica la calidad del audio durante la actividad virtual?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-17",
    "factor": "Condiciones de prestación",
    "tema": "Imagen virtual",
    "texto": "¿Cómo califica la calidad de la imagen durante la actividad virtual?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-18",
    "factor": "Condiciones de prestación",
    "tema": "Entorno visual virtual",
    "texto": "¿Qué tan adecuado fue el entorno visual o fondo utilizado por quien impartió la actividad virtual?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-19",
    "factor": "Condiciones de prestación",
    "tema": "Seguridad percibida",
    "texto": "¿Qué tan seguro se sintió durante este servicio o actividad?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-20",
    "factor": "Condiciones de prestación",
    "tema": "Espacio asignado",
    "texto": "¿Qué tan adecuado fue el espacio que le asignaron para participar?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-21",
    "factor": "Condiciones de prestación",
    "tema": "Distribución y orden",
    "texto": "¿Cómo califica la distribución y el orden de los espacios o puestos?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-22",
    "factor": "Condiciones de prestación",
    "tema": "Movilidad y circulación",
    "texto": "¿Cómo califica las condiciones para circular y desplazarse durante la actividad?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-23",
    "factor": "Condiciones de prestación",
    "tema": "Parqueo",
    "texto": "¿Cómo califica las condiciones de parqueo disponibles?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-24",
    "factor": "Condiciones de prestación",
    "tema": "Precios de comerciantes",
    "texto": "¿Qué tan justos le parecieron los precios de los productos o servicios ofrecidos?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-25",
    "factor": "Condiciones de prestación",
    "tema": "Variedad de oferta comercial",
    "texto": "¿Cómo califica la variedad de productos o alimentos ofrecidos?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-26",
    "factor": "Condiciones de prestación",
    "tema": "Elaboración de materiales en casa",
    "texto": "¿Qué tan fácil le resultó elaborar los materiales utilizados en la actividad?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-27",
    "factor": "Condiciones de prestación",
    "tema": "Medios de información",
    "texto": "¿Cómo califica los medios de información disponibles para orientarse durante la experiencia?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-28",
    "factor": "Condiciones de prestación",
    "tema": "Acceso a materiales para elaborar",
    "texto": "¿Qué tan fácil le resultó conseguir los materiales necesarios para realizar las actividades?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-29",
    "factor": "Condiciones de prestación",
    "tema": "Espacios verdes",
    "texto": "¿Cómo califica el estado de los espacios verdes utilizados o visitados?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-30",
    "factor": "Condiciones de prestación",
    "tema": "Monumentos y atractivos",
    "texto": "¿Cómo califica el estado del monumento o atractivo visitado?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-31",
    "factor": "Condiciones de prestación",
    "tema": "Día de realización",
    "texto": "¿Qué tan conveniente le resultó el día en que se realizó la actividad?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "CON-32",
    "factor": "Condiciones de prestación",
    "tema": "Música de acompañamiento",
    "texto": "¿Cómo califica la música utilizada para acompañar la actividad?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "UTL-01",
    "factor": "Utilidad y resultados",
    "tema": "Utilidad del aprendizaje o servicio",
    "texto": "¿Qué tan útil le resultó lo recibido en este servicio o actividad?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "UTL-02",
    "factor": "Utilidad y resultados",
    "tema": "Desarrollo de habilidades",
    "texto": "¿Cuánto considera que esta actividad contribuyó al desarrollo de habilidades?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "UTL-03",
    "factor": "Utilidad y resultados",
    "tema": "Bienestar de la niñez",
    "texto": "¿Cuánto considera que este servicio o actividad contribuyó al bienestar de su hijo o hija?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "UTL-04",
    "factor": "Utilidad y resultados",
    "tema": "Resultados comerciales",
    "texto": "¿Cómo valora el resultado de su participación en relación con las ventas?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Selección única",
        "opciones": [
          {
            "valor": "muy_malo",
            "etiqueta": "Muy malo"
          },
          {
            "valor": "malo",
            "etiqueta": "Malo"
          },
          {
            "valor": "regular",
            "etiqueta": "Regular"
          },
          {
            "valor": "bueno",
            "etiqueta": "Bueno"
          },
          {
            "valor": "muy_bueno",
            "etiqueta": "Muy bueno"
          },
          {
            "valor": "no_aplica",
            "etiqueta": "No aplica"
          }
        ]
      }
    ]
  },
  {
    "codigo": "UTL-05",
    "factor": "Utilidad y resultados",
    "tema": "Beneficio percibido en sus propias palabras",
    "texto": "¿Cuál fue el principal beneficio que obtuvo de este servicio o actividad?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Texto abierto",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "UTL-06",
    "factor": "Utilidad y resultados",
    "tema": "Valoración del apoyo municipal",
    "texto": "¿Cómo valora el apoyo de la Municipalidad de Guatemala a quienes participan en este servicio o actividad?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "UTL-07",
    "factor": "Utilidad y resultados",
    "tema": "Desarrollo de la niñez",
    "texto": "¿Cuánto considera que este servicio o actividad contribuyó al desarrollo de su hijo o hija?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "UTL-08",
    "factor": "Utilidad y resultados",
    "tema": "Acuerdo con la oferta municipal",
    "texto": "¿Qué tan de acuerdo está con los programas municipales ofrecidos en el ámbito de este servicio o actividad?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Escala de 0 a 10",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "MEJ-01",
    "factor": "Mejoras y necesidades futuras",
    "tema": "Aspectos por mejorar",
    "texto": "¿Qué aspectos considera que debemos mejorar en este servicio o actividad?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Selección múltiple",
        "opciones": [
          {
            "valor": "atencion",
            "etiqueta": "Trato del personal"
          },
          {
            "valor": "comunicacion",
            "etiqueta": "Comunicación y seguimiento"
          },
          {
            "valor": "contenido",
            "etiqueta": "Contenido"
          },
          {
            "valor": "ensenanza",
            "etiqueta": "Explicaciones o enseñanza"
          },
          {
            "valor": "actividades",
            "etiqueta": "Desarrollo de las actividades"
          },
          {
            "valor": "horario",
            "etiqueta": "Horario"
          },
          {
            "valor": "dia",
            "etiqueta": "Día de realización"
          },
          {
            "valor": "duracion",
            "etiqueta": "Duración"
          },
          {
            "valor": "modalidad",
            "etiqueta": "Modalidad presencial o virtual"
          },
          {
            "valor": "ubicacion",
            "etiqueta": "Ubicación"
          },
          {
            "valor": "instalaciones",
            "etiqueta": "Instalaciones"
          },
          {
            "valor": "limpieza",
            "etiqueta": "Limpieza"
          },
          {
            "valor": "materiales",
            "etiqueta": "Materiales o equipo"
          },
          {
            "valor": "puntualidad",
            "etiqueta": "Puntualidad"
          },
          {
            "valor": "seguridad",
            "etiqueta": "Seguridad"
          },
          {
            "valor": "musica",
            "etiqueta": "Música"
          },
          {
            "valor": "sonido",
            "etiqueta": "Sonido"
          },
          {
            "valor": "iluminacion",
            "etiqueta": "Iluminación"
          },
          {
            "valor": "asientos",
            "etiqueta": "Cantidad de asientos"
          },
          {
            "valor": "distribucion",
            "etiqueta": "Distribución de espacios o puestos"
          },
          {
            "valor": "movilidad",
            "etiqueta": "Movilidad y circulación"
          },
          {
            "valor": "parqueo",
            "etiqueta": "Parqueo"
          },
          {
            "valor": "precios",
            "etiqueta": "Precios de productos o alimentos"
          },
          {
            "valor": "variedad",
            "etiqueta": "Variedad de productos o alimentos"
          },
          {
            "valor": "otro",
            "etiqueta": "Otro aspecto",
            "habilita_texto": true,
            "etiqueta_texto_adicional": "Especifique su respuesta"
          },
          {
            "valor": "ninguno",
            "etiqueta": "Ninguno",
            "es_excluyente": true
          }
        ]
      }
    ]
  },
  {
    "codigo": "MEJ-02",
    "factor": "Mejoras y necesidades futuras",
    "tema": "Sugerencias abiertas",
    "texto": "¿Qué sugerencias o comentarios desea compartir para mejorar este servicio o actividad?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Texto abierto",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "MEJ-03",
    "factor": "Mejoras y necesidades futuras",
    "tema": "Demanda de nuevas actividades",
    "texto": "¿Qué otras actividades o servicios le gustaría que se ofrecieran?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Texto abierto",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "MEJ-04",
    "factor": "Mejoras y necesidades futuras",
    "tema": "Destinos y recorridos de interés",
    "texto": "¿Qué lugares o recorridos le gustaría que se incluyeran en próximas actividades?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Texto abierto",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "MEJ-05",
    "factor": "Mejoras y necesidades futuras",
    "tema": "Motivación de participación",
    "texto": "¿Cuál fue su principal motivo para participar en este servicio o actividad?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Texto abierto",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "MEJ-06",
    "factor": "Mejoras y necesidades futuras",
    "tema": "Aspectos más valorados",
    "texto": "¿Qué fue lo que más le gustó de este servicio o actividad?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Texto abierto",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "MEJ-07",
    "factor": "Mejoras y necesidades futuras",
    "tema": "Mejoras de comerciantes",
    "texto": "¿Qué aspectos deberían mejorar los comerciantes que participaron?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Selección múltiple",
        "opciones": [
          {
            "valor": "precios",
            "etiqueta": "Precios"
          },
          {
            "valor": "higiene",
            "etiqueta": "Higiene"
          },
          {
            "valor": "orden",
            "etiqueta": "Orden"
          },
          {
            "valor": "atencion",
            "etiqueta": "Atención a consumidores"
          },
          {
            "valor": "variedad",
            "etiqueta": "Variedad de productos"
          },
          {
            "valor": "otro",
            "etiqueta": "Otro",
            "habilita_texto": true,
            "etiqueta_texto_adicional": "Especifique su respuesta"
          },
          {
            "valor": "ninguno",
            "etiqueta": "Ninguno",
            "es_excluyente": true
          }
        ]
      }
    ]
  },
  {
    "codigo": "INC-01",
    "factor": "Incidencias e integridad",
    "tema": "Solicitud de pagos o donaciones",
    "texto": "¿Le solicitaron algún pago o donación por el servicio o los materiales recibidos?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Selección única",
        "opciones": [
          {
            "valor": "si",
            "etiqueta": "Sí"
          },
          {
            "valor": "no",
            "etiqueta": "No"
          },
          {
            "valor": "no_sabe",
            "etiqueta": "No sabe"
          }
        ]
      }
    ]
  },
  {
    "codigo": "INC-02",
    "factor": "Incidencias e integridad",
    "tema": "Detalle de pago o donación",
    "texto": "Describa el pago o la donación que le solicitaron.",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Texto abierto",
        "opciones": []
      }
    ]
  },
  {
    "codigo": "INC-03",
    "factor": "Incidencias e integridad",
    "tema": "Problemas o inconvenientes",
    "texto": "¿Experimentó algún problema o inconveniente durante este servicio o actividad?",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Selección única",
        "opciones": [
          {
            "valor": "si",
            "etiqueta": "Sí"
          },
          {
            "valor": "no",
            "etiqueta": "No"
          }
        ]
      }
    ]
  },
  {
    "codigo": "INC-04",
    "factor": "Incidencias e integridad",
    "tema": "Descripción de la incidencia",
    "texto": "Describa el problema o inconveniente que experimentó.",
    "obligatoria": false,
    "tipos": [
      {
        "nombre": "Texto abierto",
        "opciones": []
      }
    ]
  }
]
JSON, true, 512, JSON_THROW_ON_ERROR);

        foreach ($banco as $fila) {
            $ahora = now();

            DB::table('factores')->updateOrInsert(
                ['nombre' => $fila['factor']],
                fn (bool $exists) => ['activo' => true, 'updated_at' => $ahora] + ($exists ? [] : ['created_at' => $ahora])
            );
            $factorId = DB::table('factores')->where('nombre', $fila['factor'])->value('id');

            DB::table('temas')->updateOrInsert(
                ['nombre' => $fila['tema']],
                fn (bool $exists) => ['activo' => true, 'updated_at' => $ahora] + ($exists ? [] : ['created_at' => $ahora])
            );
            $temaId = DB::table('temas')->where('nombre', $fila['tema'])->value('id');

            DB::table('preguntas')->updateOrInsert(
                ['codigo' => $fila['codigo']],
                fn (bool $exists) => [
                    'factor_id' => $factorId,
                    'tema_id' => $temaId,
                    'texto' => $fila['texto'],
                    'es_nps' => $fila['codigo'] === 'REC-01',
                    'activo' => false,
                    'obligatoria' => (bool) $fila['obligatoria'],
                    'updated_at' => $ahora,
                ] + ($exists ? [] : ['created_at' => $ahora])
            );
            $preguntaId = DB::table('preguntas')->where('codigo', $fila['codigo'])->value('id');

            foreach ($fila['tipos'] as $configuracion) {
                $nombreTipo = $configuracion['nombre'];
                DB::table('tipos_respuesta')->updateOrInsert(
                    ['nombre' => $nombreTipo],
                    fn (bool $exists) => ['updated_at' => $ahora] + ($exists ? [] : ['created_at' => $ahora])
                );
                $tipoId = DB::table('tipos_respuesta')->where('nombre', $nombreTipo)->value('id');

                $escalaId = null;
                if ($nombreTipo === 'Escala de 0 a 10') {
                    $nombreEscala = $fila['codigo'] === 'REC-01'
                        ? 'Escala NPS de 0 a 10'
                        : 'Escala general de 0 a 10';
                    $escalaId = DB::table('escalas')->where('nombre', $nombreEscala)->value('id');
                    if ($escalaId === null) {
                        throw new RuntimeException("No existe la escala: {$nombreEscala}.");
                    }
                }

                DB::table('pregunta_tipo_respuesta')->updateOrInsert(
                    ['pregunta_id' => $preguntaId, 'tipo_respuesta_id' => $tipoId],
                    fn (bool $exists) => ['escala_id' => $escalaId, 'updated_at' => $ahora] + ($exists ? [] : ['created_at' => $ahora])
                );
                $configuracionId = DB::table('pregunta_tipo_respuesta')
                    ->where('pregunta_id', $preguntaId)
                    ->where('tipo_respuesta_id', $tipoId)
                    ->value('id');

                foreach ($configuracion['opciones'] as $opcion) {
                    DB::table('opciones_respuesta')->updateOrInsert(
                        [
                            'pregunta_tipo_respuesta_id' => $configuracionId,
                            'valor' => $opcion['valor'],
                        ],
                        fn (bool $exists) => [
                            'etiqueta' => $opcion['etiqueta'],
                            'es_excluyente' => (bool) ($opcion['es_excluyente'] ?? false),
                            'habilita_texto' => (bool) ($opcion['habilita_texto'] ?? false),
                            'etiqueta_texto_adicional' => $opcion['etiqueta_texto_adicional'] ?? null,
                            'updated_at' => $ahora,
                        ] + ($exists ? [] : ['created_at' => $ahora])
                    );
                }
            }
        }
    }

    private function crearPlantillas(): void
    {
        $plantillas = [
            ['codigo' => 'GER', 'nombre' => 'Plantilla para gerentes', 'descripcion' => 'Evaluación del desempeño para puestos gerenciales.'],
            ['codigo' => 'MM', 'nombre' => 'Plantilla para mandos medios', 'descripcion' => 'Evaluación del desempeño para jefaturas y mandos medios.'],
            ['codigo' => 'OPE', 'nombre' => 'Plantilla para personal operativo', 'descripcion' => 'Evaluación del desempeño para personal operativo.'],
        ];

        foreach ($plantillas as $plantilla) {
            DB::table('plantillas')->updateOrInsert(
                ['codigo' => $plantilla['codigo']],
                fn (bool $exists) => [
                    'nombre' => $plantilla['nombre'],
                    'descripcion' => $plantilla['descripcion'],
                    'activo' => true,
                    'updated_at' => now(),
                ] + ($exists ? [] : ['created_at' => now()])
            );
        }
    }
}
