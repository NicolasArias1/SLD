% Practica de control de velocidad

clc

% Par�metros que manda el SLD (luego hay que comentarlos)
% clear all
% Tm = 0.01;  % Per�odo de muestreo (0.001<=Tm<=1)
% P = 0.5;    % P = kp     P+I/s = (tis+1)kp/Tis
% I = P/0.5;  % I = kp/Ti
% D = 0;
% Kb = 1;     % Ganancia del Antiwindup
% Fcd = 2;    % Fc del filtro derivativo en Hz (N = 2*pi*Fcd;)
% SW = 1;     % 0 realimenta medici�n sin filtro, 1 con filtro
% Nv = 4;     % Orden del Filtro de velocidad
% Fcv = 5;    % Frecuencia de corte (Fc<Fm/2)

% Chequeo de variables en rango (OjO: no poner 0 (cero), poner O (letra o) ) 
vars = who;
if length(vars) ~= 9
    varerror = 'ERROR: Las variables no se han introducido correctamente.';
elseif Tm < 0.001 || Tm > 1
    varerror = 'ERROR: Variables fuera de rango: O.OO1 <= Tm <= 1';
elseif Fcd < 0 || Fcd > 1/(Tm*2)
    varerror = 'ERROR: Variables fuera de rango: O < Fcd < Fm/2';
elseif Nv < 1 || Nv > 10
    varerror = 'ERROR: Variables fuera de rango: 1 <= Nv <= 1O (entero)';
elseif Fcv <= 0 || Fcv >= 1/(Tm*2)
    varerror = 'ERROR: Variables fuera de rango: O < Fcv < Fm/2';
elseif ~(SW == 0 || SW == 1)
    varerror = 'ERROR: Variables fuera de rango: SW = O o 1';
else
    bdclose('all');
	% Presumo que no habr� error
	varerror = '0';
	
    Te = 10;    % Tiempo de experimento (1<=Tm<=10)
    Tp = 5;     % Instante del paso (Tp<Te)
    Vi = -50;   % Velocidad inicial
    Vf = 50;    % Velocidad final

	% Iedentificador de la pr�ctica
	PracticeFile = 'CS_PIDVr';
			    
	% Carga y setea el mdl
	eval(PracticeFile);
	set_param([PracticeFile '/Switch'],'CurrentSetting',num2str(~SW));
	
    % Salva variables para que luego las vea 'salida'
    save globales;
    
    % Compila para RT
%     try
%         make_rtw;
%     catch
%         varerror = 'Error creando el c�digo en Real Time Windows Target.';
%         return;
%     end
    
    try
        sim(gcs)
        salida(simout)
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