<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Protocols language lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during protocols views for various messages that we must show the user.
    | You are free to modify these language lines according to your application's requirements.
    |
    */

    'protocols' => 'Protocolos',
    'create_protocol' => 'Crear protocolo',
    'protocol_number' => 'Número de protocolo',
    'date' => 'Fecha',
    'type' => 'Tipo',
    'observations' => 'Observaciones',
    'diagnostic' => 'Diagnóstico',
    'quantity_orders' => 'Cantidad de órdenes',
    'completion_date' => 'Fecha de realización',
    'show_protocol' => 'Ver protocolo',
    'destroy_protocol' => 'Eliminar protocolo',
    'protocol_blocked' => 'Protocolo bloqueado por razones de seguridad. Para realizar cambios, haga clic en el candado',
    'edit_protocol' => 'Editar protocolo',
    'generate_worksheet' => 'Generar hoja de trabajo',
    'generate_protocol' => 'Generar protocolo',
    'worksheet_for_protocol' => 'Hoja de trabajo para el protocolo',
    'worksheet' => 'Hoja de trabajo',
    'report_for_protocol' => 'Informe para el protocolo',
    'unloaded_social_work' => 'El paciente no está afiliado a ninguna obra social',
    'create_notice' => 'Una vez que haya asignado el protocolo al paciente, puede agregar las prácticas que necesite',
    'generate_protocol_for_selected_practices' => 'Generar protocolo para las prácticas seleccionadas',
    'see_patient' => 'Ver paciente',
    'view_protocols' => 'Ver protocolos',
    'empty_protocol' => 'No se pueden imprimir protocolos con prácticas sin informar',
    'total_amount' => 'Monto total',
    'medical_order_data' => 'Datos de la orden médica',
    'billing_data' => 'Datos de facturación',
    'expired_social_work' => 'Credencial de la Obra social vencida. Solicite una nueva credencial al paciente',
    'close_protocol' => 'Cerrar protocolo',
    'protocol_closed_successfully' => 'Protocolo cerrado exitosamente',
    'new' => 'Nuevo',
    'closed' => 'Cerrado',
    'protocol_closed_message' => 'El protocolo ha sido cerrado y no se puede modificar por ninguna razón',
    'verify_closed_protocol' => 'El protocolo no está cerrado y por eso no se puede enviar o imprimir',
    'cannot_close_protocol_with_unsigned_practices' => 'No se puede cerrar el protocolo con prácticas no firmadas',
    'cannot_print_protocol_with_unsigned_practices' => 'No se puede imprimir el protocolo con prácticas no firmadas',
    'send_protocol_to_email' => 'Enviar protocolo por correo electrónico',
    'send_protocol_email_successfully' => 'Protocolo enviado por correo electrónico exitosamente',
    'not_loaded_practices' => 'Para cerrar un protocolo debe haber cargado al menos una práctica',
    'select_practices_to_print' => 'Seleccione las prácticas a imprimir',
    'practice_detected_not_belong_protocol' => 'Se detectó una práctica que no pertenece al protocolo',
    'not_selected_practices' => 'No se seleccionaron prácticas',
    'send_selected_practices_by_email' => 'Enviar las prácticas seleccionadas por correo electrónico',
    'protocols_message' => 'Esta sección es el corazón de su Laboratorio. Aquí se cargan todos los protocolos internos y cada uno de ellos se asigna a uno de sus pacientes. Contienen las prácticas realizadas por el paciente, el prescriptor que recetó la orden, los datos de la obra social, entre otras cosas',
    'error_modifying_social_work' => 'Para modificar la obra social, primero borre todas las prácticas de protocolo',
    'success_destroy_message' => '¡Bien hecho! El protocolo se eliminó con éxito',
    'protocols_create_message' => 'Para crear un protocolo, debes seleccionar al menos al paciente, la obra social y el prescriptor. Luego puedes cargar las prácticas que realizarás en el paciente',
    'patient_help' => 'Al seleccionar un paciente, cargaremos automáticamente su obra social',
    'prescriber_help' => 'Asocia un prescriptor al protocolo para continuar',
    'social_work_help' => 'Puedes cargar cualquier obra social aunque no sea la que tenga el paciente',
    'plan_help' => 'El plan se cargará automáticamente al seleccionar una obra social',
    'completion_date_help' => 'Indica la fecha en que se realizaron las prácticas. Por esta fecha se ordenan los protocolos',
    'diagnostic_help' => 'El diagnóstico presuntivo de la prescripción médica para la cual se realizan las determinaciones',
    'billing_period_help' => 'Este campo te ayuda a realizar el corte de facturación más tarde',
    'quantity_orders_help' => 'El número de órdenes entregadas por el paciente',
    'protocols_edit_message' => 'La mayor parte de nuestro trabajo se realiza en este documento. Trata de completar tantos campos como sea posible para dejar una historia clínica clara. Una vez cerrado el protocolo, puedes generar un PDF y no se puede modificar de nuevo por ninguna razón',
    'observations_help' => 'Cualquier detalle sobre el proceso o los resultados del análisis. Estas observaciones son públicas',
    'see_protocol_practices' => 'Ver prácticas del protocolo',
    'patient_protocols_message' => 'Acá puede buscar todos los protocolos internos asignados a un paciente. Contienen las prácticas realizadas por el paciente, el prescriptor que prescribió la orden, los datos de la obra social, entre otras cosas',
    'search_protocols_from_help' => 'La fecha a partir de la cual se comenzarán a buscar los protocolos',
    'search_protocols_until_help' => 'La fecha hasta la cual finalizará la búsqueda de los protocolos',
    'search_patient_protocols_help' => 'Seleccioná al paciente para el cual deseas buscar protocolos',
    'search_protocols_is_empty' => 'No se encontraron protocolos en el rango de fechas proporcionado',
    'show_patient_protocol_message' => 'Acá se encuentran todos los datos de su informe de laboratorio. Podrá visualizar la fecha de entrega de los resultados, generar los resultados de laboratorio en un archivo pdf, enviarlos a su correo electrónico, y mucho más...',

];
