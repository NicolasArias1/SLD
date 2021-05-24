%ter20120423131148r

vars = who;
if length(vars) == 4
    if   a >= 1 && a < 10 && b >= 0 && b < 5 && c >= 0 && c < 10 && d >= 0 && d < 10        
		    bdclose('all');
		    %Presumo no hay error
			varerror = '0';
		    
			% Datos especificos de Tr
		    PracticeFile = 'ter20120423131148r';       %'termicoddmmaahhmmssr';
		    Graph1File   = 'temperaturar.jpg';
		    Plot1        = 'plot(temp(:,1),temp(:,2:3))';
		    Graph2File   = 'mandotr.jpg';
		    Plot2        = 'plot(man(:,1),man(:,2))';
		    		    
		    % Inicilizar la cadena de retorno.
		    retstr = char('');
		    
		    % Inicializacion de la estructura de datos
		    p = what;
		    mldir  = p.path;          % Path completo donde esta el mdl y el html plantilla
		    outdir = [p.path '\out']; % Path donde quedara el html resultante con sus graficas OjO: debe copiarse a él el esquema
		    		    
		    pf = PracticeFile;
		    
		    % Realice los calculos de MATLAB
		    eval(pf);		    		     
            
            try
                make_rtw;
            catch
                varerror = 'Error creando el código en Real Time Windows Target';
                return;
            end 
            
            try                                
                %Simulink cambia a modo externo
                set_param(gcs,'SimulationMode','external');
                
                %MatLab carga la aplicacion en tiempo real y la conecta con los bloques de simulink
                set_param(gcs,'SimulationCommand','connect');
 
                %Inicializa la simulacion en tiempo  real
                set_param(gcs,'SimulationCommand','start');
            catch
                varerror= 'Hubo error en la ejecución del modelo.';
                return;
            end
               
    else
    	varerror= 'ERROR 1: Hay variables fuera de rango.';
    end
else
    varerror= 'ERROR 2: Las variables no se han introducido correctamente';
end

% 1 = ERROR: Hay variables fuera de rango.
% 2 = ERROR: Las variables no se han introducido correctamente.Numero de parametros =4 <---Este es ! 
