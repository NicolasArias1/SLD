% Practica de Identificación de motor al paso
% Sin filtro

clc

% Datos para la identificación
% clear all
% Tm = 0.2;  % Período de muestreo (0.001<=Tm<=1)
% Te = 2;    % Tiempo de experimento (1<=Te<=10)
% Tp = 1;    % Instante del paso (Tp<Te)
% Vi = 2;    % Voltaje inicial del paso
% Vf = 4;    % Voltaje final del paso

vars = who;
if length(vars) ~= 5
    varerror = 'ERROR: Las variables no se han introducido correctamente.';
elseif Tm < 0.001 || Tm > 1
    varerror = 'ERROR: Variables fuera de rango: O.OO1 <= Tm <= 1';
elseif Te < 1 || Te > 10
    varerror = 'ERROR: Variables fuera de rango: 1 <= Te <= 1O';
elseif Tp < 0 || Tp >= Te
    varerror = 'ERROR: Variables fuera de rango: O <= Tp < Te';
elseif Vi < -10 || Vi > 10
    varerror = 'ERROR: Variables fuera de rango: -1O <= Vi <= 1O';
elseif Vf < -10 || Vf > 10
    varerror = 'ERROR: Variables fuera de rango: -1O <= Vf <= 1O';
else
    bdclose('all');
	%Presumo no hay error
	varerror = '0';
		    
	% Datos especificos de CT_T1_PIDr
	id           = 'CS_IDr';
	PracticeFile = 'CS_IDr';
	Graph1File   = 'CS_ID_mando.jpg';
	Plot1        = 'stairs(simout.time, simout.signals.values(:,1))';
    Graph2File   = 'CS_ID_velocidad.jpg';
	Plot2        = 'stairs(simout.time, simout.signals.values(:,2))';
	Graph3File   = 'CS_ID_posicion.jpg';
	Plot3        = 'stairs(simout.time, simout.signals.values(:,3))';
		    		    
	% Inicilizar la cadena de retorno.
	retstr = char('');
		    
	% Inicializacion de la estructura de datos
	p = what;
	mldir  = p.path;          % Path completo donde esta el mdl y el html plantilla
	outdir = [p.path '\out']; % Path donde quedara el html resultante con sus graficas OjO: debe copiarse a él el esquema
	htmldir = [p.path '\html'];
		    
	pf = PracticeFile;
		    
	% Realice los calculos de MATLAB
	eval(pf);
	%set_param([pf '/PID with Anti-windup'],'P',num2str(P));
	 
    % Graba las variables del workspace
    save globales;

%     % Creo el codigo
%     try
%         make_rtw;
%     catch
%         varerror = 'Error creando el código en Real Time Windows Target.';
%         return;
%     end
    
    try
        sim(gcs);
        salida(simout);
%         % Simulink cambia a modo externo
%         set_param(gcs,'SimulationMode','external');
%         % MatLab carga la aplicacion en tiempo real y la conecta con los bloques de simulink
%         set_param(gcs,'SimulationCommand','connect');
%         % Inicializa la simulacion en tiempo  real
%         set_param(gcs,'SimulationCommand','start');
    catch
        varerror = 'Error ejecutando el modelo.';
        return;
    end
	
end

varerror
