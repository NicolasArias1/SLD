% Practica real de control de servomecanismo con cambio de controlador

clc
clear all
bdclose('all');

% Identificador de la pr�ctica (termina en r porque es real)
PracticeID = 'CS_Cr';

% PracticeID.mdl:           Es el mdl que se ejecutar� (destino)
% PracticeID_resguardo.mdl: Es el mdl de reposici�n
% PracticeID_V75R2010a.mdl: Es el mdl que se descarga
% Se hace el primero, se deja copia en el segundo y se exporta el tercero 

% Modelo enviado por el usuario
usermdl = '.\regulador\ureg.mdl';
% MAT enviado por el usuario
usermat = '.\ficheromat\umat.mat';

% Validaci�n de que, si se envio, se pueda abrir el .mat
if exist(usermat,'file'),
    try
        load(usermat);
    catch
        varerror = 'No se pudo abrir el ficheo .mat enviado.';
        delete(usermdl);
        delete(usermat);
        return;
    end
    delete(usermat);
end

% Verificaci�n de recepci�n de fichero enviado
if exist(usermdl,'file') == 0
    varerror = 'No se recibi� ning�n modelo para ejecutar.';
	return;
end

% Validaci�n del fichero enviado
try
    info = Simulink.MDLInfo(usermdl);
catch
    varerror = 'El fichero enviado no es de Simulink.';
    delete(usermdl);
    return
end

% Validaci�n de la versi�n del modelo
simulink_version = info.SimulinkVersion;
v = str2double(simulink_version);
if (v==-1)||(v>8.4)
    varerror = 'Se envi� un modelo Simulink no compatible. Debe ser .mdl versi�n Simulink <= 8.4(R2014b)';
    delete(usermdl);
	return;
end

% Validaci�n de que se pueda abrir el modelo
try
    load_system(usermdl);
catch
    varerror = 'No se pudo abrir el modelo enviado. Debe ser .mdl versi�n Simulink <= 8.4(R2014b)';
	delete(usermdl);
    return;
end

% Validaci�n de que el modelo corra en simulaci�n
try
    sim(gcs);
catch
    varerror = 'Error ejecutando el modelo en simulaci�n.';
    bdclose('all');
    delete(usermdl);
    return;
end

% Restauraci�n del modelo
mdlresguardo = [PracticeID '_resguardo.mdl'];
mdldestin = [PracticeID '.mdl'];
load_system(mdlresguardo);
save_system(mdlresguardo,mdldestin);

% Remplazo de los bloques
varerror = replace( usermdl, mdldestin );
delete(usermdl);
if varerror ~= '0'
    bdclose('all');
    return
end

try
    open_system(mdldestin);
catch
	varerror = 'Error cargando el modelo RT con el bloque enviado.';
    bdclose('all');
    return;
end

% Salva variables para que luego las vea 'salida'
%save globales; % en R2014b da problemas el load

% Se compila
% try
% 	  make_rtw;
% catch
%     varerror = 'Error creando el c�digo en Real Time Windows Target.';
%     bdclose('all');
%     return;
% end 
    
try   
    sim(gcs);
    salida(aux1,aux2,aux3,man)
% 	% Simulink cambia a modo externo
% 	set_param(gcs,'SimulationMode','external');
% 
%     % MatLab carga la aplicacion en tiempo real y la conecta con los bloques de simulink
%     set_param(gcs,'SimulationCommand','connect');
%  
%     % Inicializa la simulacion en tiempo  real
%     set_param(gcs,'SimulationCommand','start');
catch
    varerror = 'Error ejecutando el modelo en tiempo real.';
    bdclose('all');
    return;
end

% No hubo error
varerror = '0';