function retstr = salida(aux1,aux2,aux3,man)
% Practica de control de motor

% Inicilizar la cadena de retorno.
retstr = char('');

% Carga variables por si se necesita alguna
% por ejemplo PracticeID
%load globales;

% Identificador de la práctica (termina en r porque es real)
PracticeID = 'CS_Cr';
    
% Salto a la carpeta de salida
cd('out');
		    
% Genera puntero a figura
h = figure('visible','off');
p = get(gcf, 'position');
p(3) = 380;
p(4) = 310;
set(gcf, 'Position', p, 'PaperPosition', [.25 .25 4 3]);
    
% Creando figura 1
GraphName   = 'CS_C_aux1.jpg';
stairs(aux1.time, aux1.signals.values);
legend('Auxiliares 1','Location','SouthEast');
grid on;
GraphFile = sprintf(GraphName);
print(h, '-djpeg', '-r0', GraphFile);

% Creando figura 2
GraphName   = 'CS_C_aux2.jpg';
stairs(aux2.time, aux2.signals.values);
legend('Auxiliares 2','Location','SouthEast');
grid on;
GraphFile = sprintf(GraphName);
print(h, '-djpeg', '-r0', GraphFile);

% Creando figura 3
GraphName   = 'CS_C_aux3.jpg';
stairs(aux3.time, aux3.signals.values);
legend('Auxiliares 3','Location','SouthEast');
grid on;
GraphFile = sprintf(GraphName);
print(h, '-djpeg', '-r0', GraphFile);

% Creando figura 4
GraphName   = 'CS_C_mando.jpg';
stairs(man.time, man.signals.values);
legend('Mando aplicado (V)','Location','SouthEast');
grid on;
GraphFile = sprintf(GraphName);
print(h, '-djpeg', '-r0', GraphFile);

close(h);
            		    
% Creando el fichero de respuesta.
vec = [man.time aux1.signals.values aux2.signals.values aux3.signals.values man.signals.values];
str = ['save ' PracticeID ' vec -ascii -tabs'];
eval(str);
		    
% Retorno a la carpeta de trabajo
cd('..');
		    
varerror = '0';
   