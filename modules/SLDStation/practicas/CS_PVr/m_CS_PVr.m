% Practica de control en cascada

clc

% Parámetros que manda el SLD (luego hay que comentarlos)
% clear all
% 
% Tm = 0.01;  % Período de muestreo (0.001<=Tm<=1)
% 
% Pp = 0.5290;   % P = kp     P+I/s = (tis+1)kp/Tis
% Ip = 0;     % I = kp/Ti
% Dp = 0;
% Kbp = 0;    % Ganancia del Antiwindup
% Fcdp = 5;   % Fc del filtro derivativo en Hz (N = 2*pi*Fcd;)
% SWp = 1;    % 0 realimenta medición sin filtro, 1 con filtro
% Np = 2;     % Orden del Filtro de posición
% Fcp = 5;    % Frecuencia de corte (Fc<Fm/2)
% 
% Pv = 0.3173;   % P = kp     P+I/s = (tis+1)kp/Tis
% Iv = 0.6346;     % I = kp/Ti
% Dv = 0;
% Kbv = 1;    % Ganancia del Antiwindup
% Fcdv = 5;   % Fc del filtro derivativo en Hz (N = 2*pi*Fcd;)
% SWv = 1;    % 0 realimenta medición sin filtro, 1 con filtro
% Nv = 2;     % Orden del Filtro de velocidad
% Fcv = 5;    % Frecuencia de corte (Fc<Fm/2)

% Chequeo de variables en rango (OjO: no poner 0 (cero), poner O (letra o) ) 
vars = who;
if length(vars) ~= 17
    varerror = 'ERROR: Las variables no se han introducido correctamente.';
elseif Tm < 0.001 || Tm > 1
    varerror = 'ERROR: Variables fuera de rango: O.OO1 <= Tm <= 1';
elseif Fcdp < 0 || Fcdp > 1/(Tm*2)
    varerror = 'ERROR: Variables fuera de rango: O < Fcd < Fm/2';
elseif Np < 1 || Np > 10
    varerror = 'ERROR: Variables fuera de rango: 1 <= Nv <= 1O (entero)';
elseif Fcp <= 0 || Fcp >= 1/(Tm*2)
    varerror = 'ERROR: Variables fuera de rango: O < Fcp < Fm/2';
elseif ~(SWp == 0 || SWp == 1)
    varerror = 'ERROR: Variables fuera de rango: SW = O o 1';
elseif Fcdv < 0 || Fcdv > 1/(Tm*2)
    varerror = 'ERROR: Variables fuera de rango: O < Fcd < Fm/2';
elseif Nv < 1 || Nv > 10
    varerror = 'ERROR: Variables fuera de rango: 1 <= Nv <= 1O (entero)';
elseif Fcv <= 0 || Fcv >= 1/(Tm*2)
    varerror = 'ERROR: Variables fuera de rango: O < Fcv < Fm/2';
elseif ~(SWv == 0 || SWv == 1)
    varerror = 'ERROR: Variables fuera de rango: SW = O o 1';
else
    bdclose('all');
	% Presumo que no habrá error
	varerror = '0';
	
    Te = 10;    % Tiempo de experimento (1<=Tm<=10)
    Tp = 5;     % Instante del paso (Tp<Te)
    Pi = -50;   % Posición inicial
    Pf = 50;    % Posición final

	% Iedentificador de la práctica
	PracticeFile = 'CS_PVr';
			    
	% Carga y setea el mdl
	eval(PracticeFile);
	set_param([PracticeFile '/VSelector'],'CurrentSetting',num2str(~SWv));
    set_param([PracticeFile '/PSelector'],'CurrentSetting',num2str(~SWp));
	
    % Salva variables para que luego las vea 'salida'
    save globales;
    
    % Compila para RT
    try
        make_rtw;
    catch
        varerror = 'Error creando el código en Real Time Windows Target.';
        return;
    end
    
    try
        % Simulink cambia a modo externo
        set_param(gcs,'SimulationMode','external');
        % MatLab carga la aplicacion en tiempo real y la conecta con los bloques de simulink
        set_param(gcs,'SimulationCommand','connect');
        % Inicializa la simulacion en tiempo  real
        set_param(gcs,'SimulationCommand','start');
    catch
        varerror = 'Error ejecutando el modelo.';
        return;
    end
	
end

varerror