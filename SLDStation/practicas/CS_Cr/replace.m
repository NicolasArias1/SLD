function error = replace( fuente, destino )

load_system(destino); % OjO no se hace chequeo de existencia del destino porque eso es mi responsabilidad

[path,fuente,ext] = fileparts(fuente);
[path,destino,ext] = fileparts(destino);

% Remplazo del período de muestreo
p_muestreo = get_param(fuente,'FixedStep'); %obtengo tm de la fuente
if isnan(str2double(p_muestreo)) || (str2double(p_muestreo) < 0.001) || (str2double(p_muestreo) > 1) 
    error = 'El período de muestreo debe ser un número y cumplir: O.OO1 <= Tm <= 1';
	return;
end
set_param(destino,'FixedStep', p_muestreo); %cambio tm
    
% Remplazo del tiempo de ejecución hasta 60s
t_final = get_param(fuente,'StopTime');
if isnan(str2double(t_final)) || (str2double(t_final) <= 0) || (str2double(t_final) > 60)
    error = 'El tiempo de ejecución debe ser un número mayor que O y hasta 6Os.';
	return;
end
set_param(destino, 'StopTime', t_final);

% Remplazo del bloque controlador
try 
    replace_block(destino,'Name','Controlador',[fuente '/Controlador'],'noprompt'); 
catch
	error = 'No se pudo efectuar el remplazo del filtro.';
	return;
end;

save_system(destino); % para cargarlo visible para ejecutarlo

bdclose('all');

error = '0';
