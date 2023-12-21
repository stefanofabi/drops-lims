<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Patient language lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during patient views for various messages that we must show the user.
    | You are free to modify these language lines according to your application's requirements.
    |
    */

    'patients' => 'Pacientes',
    'create_patient' => 'Crear paciente',
    'patient' => 'Paciente',
    'identification_number' => 'Número de identificación',
    'city' => 'Ciudad',
    'home_address' => 'Domicilio',
    'birthdate' => 'Fecha de nacimiento',
    'edit_patient' => 'Editar paciente',
    'destroy_patient' => 'Eliminar paciente',
    'sex' => 'Sexo',
    'female' => 'Femenino',
    'male' => 'Masculino',
    'patient_blocked' => 'Paciente bloqueado por razones de seguridad. Para hacer cambios, haga clic en el candado',
    'show_patient' => 'Ver paciente',
    'last_name' => 'Apellido',
    'name' => 'Nombre',
    'age' => 'Edad',
    'calculate_age' => '{0} :month mes(es) y :day día(s) |[1,*] :year año(s) y :month mes(es)',
    'send_security_code' => 'Enviar nuevo código de seguridad para vincular',
    'security_code' => 'Código de seguridad',
    'notice_confidentiality' => '¡Esta es una notificación de seguridad! No pierda, comparta ni publique este código. El personal del laboratorio nunca se pondrá en contacto con usted por ningún motivo. Si pierde este código, comuníquese de inmediato porque sus datos y resultados médicos pueden estar expuestos',
    'expiration_notice' => 'Este código caduca el :date',
    'unique_identifier' => 'Identificador único',
    'security_code_for' => 'Código de seguridad para el paciente #:id',
    'success_destroy_message' => '¡Bien hecho! El paciente se eliminó correctamente',
    'email' => 'Correo electrónico',
    'alternative_email' => 'Correo electrónico alternativo',
    'phone' => 'Teléfono',
    'alternative_phone' => 'Teléfono alternativo',
    'personal_data' => 'Datos personales',
    'bonding_date' => 'Fecha de vinculación',
    'send_security_code_successfully' => 'Código de seguridad enviado con éxito',
    'patient_have_not_email' => 'El paciente no tiene correo electrónico cargado',
    'reserve_shift' => 'Reservar turno',
    'patients_message' => 'Aquí están todos los pacientes cargados en el sistema que pueden ser tratados en su laboratorio. Recuerde que es importante verificar y mantener sus datos actualizados',
    'patients_create_message' => 'Cada vez que llegue un paciente nuevo, debe registrarlo en el sistema para luego generar un protocolo a su nombre',
    'name_help' => 'Este nombre es el que aparece al generar un protocolo en formato pdf',
    'last_name_help' => 'Este apellido es el que aparece al generar un protocolo en formato pdf',
    'identification_number_help' => 'Es el número que identifica a una persona en un país',
    'sex_help' => 'Algunas determinaciones pueden ser solo para un sexo',
    'home_address_help' => 'Calle y número donde vive el paciente',
    'city_help' => 'Ciudad donde reside el paciente',
    'birthdate_help' => 'Además de conocer su edad, le enviaremos un saludo en su cumpleaños',
    'phone_help' => 'Número principal de teléfono celular donde podemos contactar al paciente',
    'alternative_phone_help' => 'Número secundario de teléfono celular donde podemos contactar al paciente',
    'email_help' => 'Enviaremos todas las notificaciones a este correo electrónico, incluyendo los protocolos en formato pdf',
    'alternative_email_help' => 'Siempre deje un correo electrónico secundario en caso de cualquier inconveniente',
    'social_work_help' => 'La obra social o prepaga que cubrirá las prácticas del paciente',
    'plan_help' => 'El plan se cargará automáticamente cuando seleccione una obra social',
    'affiliate_number_help' => 'Número de afiliado tal como aparece en la credencial del afiliado',
    'security_code_help' => 'El código de seguridad que aparece en el reverso de la credencial del afiliado',
    'expiration_date_help' => 'Notificaremos al paciente cuando su tarjeta esté por vencer',
    'patients_edit_message' => 'Recuerda mantener actualizados los datos de los pacientes para estar en contacto con ellos y poder brindarles una mejor experiencia en tu laboratorio',
    'age_help' => 'Algunos análisis clínicos pueden cambiar dependiendo de la edad del paciente',
    
];
