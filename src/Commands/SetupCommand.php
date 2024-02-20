<?php

namespace Dizit\Auth\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class SetupCommand extends BaseCommand
{
    protected $group = 'Dizit';
    protected $name = 'auth:setup';
    protected $description = 'Configura o auth.';

    public function run(array $params)
    {
        CLI::write('Configurando o auth...', 'green');

        $directories = [
            'Cells' => 'Cells/',
            'Models' => 'Models/',
            'Views' => 'Views/',
            'Controllers' => 'Controllers/',
            'Database' => 'Database',
            'Helpers' => 'Helpers/',
            'Libraries' => 'Libraries/',
            'Filters' => 'Filters/',
            'PublicHTML' => '../public_html/',
            // Adicione mais diretórios conforme necessário
        ];

        foreach ($directories as $key => $relativePath) {
            $this->copyFilesFromDirectory($key, $relativePath);
        }

        $this->addRoute("// Auto Routes - Packages");
        $this->addRoute("\$routes->get('auth', 'Admin\Auth::login');");
        $this->addRoute("\$routes->get('auth/logout', 'Admin\Auth::logout');");
        $this->addRoute("\$routes->post('auth', 'Admin\Auth::signin', ['filter' => 'csrf']);");
        $this->addRoute("\$routes->get('auth/password-recovery', 'Admin\Auth::password_recovery');");
        $this->addRoute("\$routes->post('auth/password-recovery', 'Admin\Auth::send_recovery_link', ['filter' => 'csrf']);");
        $this->addRoute("\$routes->get('auth/password-reset/(:any)', 'Admin\Auth::reset_password/$1');");
        $this->addRoute("\$routes->post('auth/password-reset/(:any)', 'Admin\Auth::update_password/$1', ['filter' => 'csrf']);");

        $this->addRoute("\$routes->group('admin', ['filter' => 'admin_auth'], static function (\$routes) {");
        $this->addRoute("   \$routes->resource('configuracoes', ['controller' => 'Admin\\Configuracoes']);");
        $this->addRoute("   \$routes->get('usuario', 'Admin\\Usuario::show');");
        $this->addRoute("   \$routes->put('usuario', 'Admin\\Usuario::update');");
        $this->addRoute("   \$routes->get('dashboard', 'Admin\\Dashboard::index');");
        $this->addRoute("});");


        // execute os seeder        
        CLI::write('[LEMBRETE] Execute os comandos:', 'red');
        CLI::write('php spark migrate', 'red');
        CLI::write('php spark db:seed UsersSeeder', 'red');
        CLI::write('composer require firebase/php-jwt', 'red');
    }
    private function copyFilesFromDirectory($directoryName, $relativePath)
    {
        $sourceDir = VENDORPATH . 'dizitcodes/auth/src/' . $directoryName . '/';
        $destinationDir = APPPATH . $relativePath;

        $this->recursiveCopy($sourceDir, $destinationDir);
    }

    private function recursiveCopy($src, $dst)
    {
        $dir = opendir($src);
        if (!is_dir($dst)) {
            mkdir($dst, 0755, true);
        }

        while (($file = readdir($dir)) !== false) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($src . '/' . $file)) {
                    $this->recursiveCopy($src . '/' . $file, $dst . '/' . $file);
                    // Opcional: remover o diretório de origem após copiar seu conteúdo
                    // rmdir($src . '/' . $file);
                } else {
                    $sourceFile = $src . '/' . $file;
                    $destinationFile = $dst . '/' . $file;
                    if (!file_exists($destinationFile)) {
                        if (!copy($sourceFile, $destinationFile)) {
                            CLI::write("Falha ao copiar {$sourceFile}...", 'red');
                        } else {
                            CLI::write("{$file} copiado com sucesso para {$destinationFile}", 'green');
                            // Excluir o arquivo de origem após a cópia
                            unlink($sourceFile);
                        }
                    } else {
                        CLI::write("{$file} já existe em {$destinationFile}. Nenhuma ação foi tomada.", 'yellow');
                        unlink($sourceFile);
                    }
                }
            }
        }
        closedir($dir);
    }


    private function addRoute($routeDefinition)
    {
        $routesPath = APPPATH . 'Config/Routes.php';

        // Verifique se o arquivo de rotas existe
        if (!file_exists($routesPath)) {
            CLI::write("O arquivo de rotas não foi encontrado em {$routesPath}", 'red');
            return;
        }

        // Verifique se a linha já existe no arquivo
        $contents = file_get_contents($routesPath);
        if (strpos($contents, $routeDefinition) !== false) {
            CLI::write('A rota especificada já existe no arquivo de rotas.', 'yellow');
            return;
        }

        // Adicione a linha ao final do arquivo
        if (!file_put_contents($routesPath, PHP_EOL . $routeDefinition, FILE_APPEND)) {
            CLI::write("Não foi possível escrever no arquivo de rotas em {$routesPath}", 'red');
        } else {
            CLI::write('A rota foi adicionada com sucesso.', 'green');
        }
    }
}
