function retstr = salida(simout)
% Practica de control de velocidad

% Inicilizar la cadena de retorno.
retstr = char('');

% Carga variables por si se necesita alguna
% por ejemplo PracticeFile
load globales;
    
% Salto a la carpeta de salida
cd('out');
		    
% Genera puntero a figura
h = figure('visible','off');
p = get(gcf, 'position');
p(3) = 380;
p(4) = 310;
set(gcf, 'Position', p, 'PaperPosition', [.25 .25 4 3]);
    
% Creando figura 1
Ti = 4.5;
Tf = 6.5;
GraphName   = 'CS_PIDV_velzoom.jpg';
stairs(simout.time(round(Ti/Tm):round(Tf/Tm)), simout.signals.values(round(Ti/Tm):round(Tf/Tm),1:3)); 
legend('Velocidad deseada (rpm)','Velocidad medida (rpm)','Velocidad filtrada (rpm)','Location','SouthEast');
grid on;
GraphFile = sprintf(GraphName);
print(h, '-djpeg', '-r0', GraphFile);

% Creando figura 2
GraphName   = 'CS_PIDV_velocidad.jpg';
stairs(simout.time, simout.signals.values(:,1:3));
legend('Velocidad deseada (rpm)','Velocidad medida (rpm)','Velocidad filtrada (rpm)','Location','SouthEast');
grid on;
GraphFile = sprintf(GraphName);
print(h, '-djpeg', '-r0', GraphFile);

% Creando figura 3
GraphName   = 'CS_PIDV_mando.jpg';
stairs(simout.time, simout.signals.values(:,4:5));
legend('Mando aplicado (V)','Mando calculado (V)','Location','SouthEast');
grid on;
GraphFile = sprintf(GraphName);
print(h, '-djpeg', '-r0', GraphFile);

% Creando figura 4
GraphName   = 'CS_PIDV_acciones.jpg';
stairs(simout.time, simout.signals.values(:,6:8));
legend('Acción proporcional (V)','Acción integral (V)','Acción derivativa (V)','Location','SouthEast');
grid on;
GraphFile = sprintf(GraphName);
print(h, '-djpeg', '-r0', GraphFile);
		    
close(h);
            		    
% Creando el fichero de respuesta.
vec = [simout.time simout.signals.values];
str = ['save ' PracticeFile ' vec -ascii -tabs'];
eval(str);
		    
% Retorno a la carpeta de trabajo
cd('..');
		    
varerror = '0';
