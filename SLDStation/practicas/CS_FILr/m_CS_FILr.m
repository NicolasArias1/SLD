% Practica de ajuste de filtros

clc

% Datos para la identificación
% clear all
% Tm = 0.001;  % Período de muestreo (0.001<=Tm<=1)
% Nv = 2;    % Orden del Filtro de velocidad
% Fcv = 1;   % Frecuencia de corte (Fc<Fm/2)
% Np = 2;    % Orden del Filtro de posición
% Fcp = 1;   % Frecuencia de corte (Fc<Fm/2)

vars = who;
if length(vars) ~= 5
    varerror = 'ERROR: Las variables no se han introducido correctamente.';
elseif Tm < 0.001 || Tm > 1
    varerror = 'ERROR: Variables fuera de rango: O.OO1 <= Tm <= 1';
elseif Nv < 1 || Nv > 10
    varerror = 'ERROR: Variables fuera de rango: 1 <= Nv <= 1O (entero)';
elseif Np < 1 || Np > 10
    varerror = 'ERROR: Variables fuera de rango: 1 <= Np <= 1O (entero)';
elseif Fcv <= 0 || Fcv >= 1/(Tm*2)
    varerror = 'ERROR: Variables fuera de rango: O < Fcv < Fm/2';
elseif Fcp <= 0 || Fcp >= 1/(Tm*2)
    varerror = 'ERROR: Variables fuera de rango: O < Fcv < Fm/2';
else
    bdclose('all');
	%Presumo no hay error
	varerror = '0';
	
    Te = 10;    % Tiempo de experimento (1<=Tm<=10)
    Tp = 5;    % Instante del paso (Tp<Te)
    Vi = -5;    % Voltaje inicial del paso
    Vf = 5;    % Voltaje final del paso

	% Datos especificos de CT_T1_PIDr
	id           = 'CS_FILr';
	PracticeFile = 'CS_FILr';
	Graph1File   = 'CS_FIL_velocidad.jpg';
	Plot1        = 'stairs(simout.time, simout.signals.values(:,1:2))';
	Graph2File   = 'CS_FIL_posicion.jpg';
	Plot2        = 'stairs(simout.time, simout.signals.values(:,3:4))';
		    		    
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

    % Creo el codigo
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