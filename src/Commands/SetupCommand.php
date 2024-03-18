<?php

namespace Dizit\Panel\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class SetupCommand extends BaseCommand
{
    protected $group = 'Dizit';
    protected $name = 'panel:setup';
    protected $description = 'Configura o painel.';

    public function run(array $params)
    {
        CLI::write('Configurando o painel...', 'green');

        $directories = [
            'Cells' => 'Cells/',
            'Models' => 'Models/',
            'Views' => 'Views/',
            'Controllers' => 'Controllers/',
            'Database' => 'Database',
            'Helpers' => 'Helpers/',
            'Libraries' => 'Libraries/',
            'Filters' => 'Filters/',
            'PublicHTML' => '../public/',
            // Adicione mais diretórios conforme necessário
        ];


        foreach ($directories as $key => $relativePath) {
            $this->copyFilesFromDirectory($key, $relativePath);
        }

        $sourceFile = VENDORPATH . 'dizitcodes/panel/src/env';
        $destinationFile = ROOTPATH . '/dizit.env';
        if (file_exists($sourceFile)) {
            if (!file_exists($destinationFile)) {
                if (!copy($sourceFile, $destinationFile)) {
                    CLI::write("Falha ao copiar {$sourceFile}...", 'red');
                } else {
                    CLI::write("{$sourceFile} copiado com sucesso para {$destinationFile}", 'green');
                    // Excluir o arquivo de origem após a cópia
                    unlink($sourceFile);
                }
            } else {
                CLI::write("{$sourceFile} já existe em {$destinationFile}. Nenhuma ação foi tomada.", 'yellow');
                // unlink($sourceFile);
            }
        }

        $this->addRoute("// START - Auto Routes - Packages");
        $this->addRoute("\$routes->get('auth', 'Admin\Auth::login');");
        $this->addRoute("\$routes->get('auth/logout', 'Admin\Auth::logout');");
        $this->addRoute("\$routes->post('auth', 'Admin\Auth::signin', ['filter' => 'csrf']);");
        $this->addRoute("\$routes->get('auth/password-recovery', 'Admin\Auth::password_recovery');");
        $this->addRoute("\$routes->post('auth/password-recovery', 'Admin\Auth::send_recovery_link', ['filter' => 'csrf']);");
        $this->addRoute("\$routes->get('auth/password-reset/(:any)', 'Admin\Auth::reset_password/$1');");
        $this->addRoute("\$routes->post('auth/password-reset/(:any)', 'Admin\Auth::update_password/$1', ['filter' => 'csrf']);");
        $this->addRoute("\n\n");
        $this->addRoute("\$routes->resource('admin/configuracoes', ['controller' => 'Admin\\Configuracoes', 'filter' => 'admin_auth']);");
        $this->addRoute("\$routes->get('admin/usuario', 'Admin\\Usuario::show', ['filter' => 'admin_auth']);");
        $this->addRoute("\$routes->put('usuario', 'Admin\\Usuario::update', ['filter' => 'admin_auth']);");
        $this->addRoute("\$routes->get('dashboard', 'Admin\\Dashboard::index', ['filter' => 'admin_auth']);");
        $this->addRoute("\$routes->addRedirect('admin', 'admin/dashboard');");
        $this->addRoute("\$routes->addRedirect('painel', 'admin/dashboard');");
        $this->addRoute("// END - Auto Routes - Packages");


        //
        CLI::write("\n\nSugestão de HASH: " . $this->gerarHashAleatorio(), 'blue');
    }
    private function copyFilesFromDirectory($directoryName, $relativePath)
    {
        $sourceDir = VENDORPATH . 'dizitcodes/panel/src/' . $directoryName . '/';
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

    private function gerarHashAleatorio()
    {
        // Gera 20 bytes aleatórios
        $bytes = openssl_random_pseudo_bytes(20);
        // Converte os bytes para uma string hexadecimal de 40 caracteres
        $hash = bin2hex($bytes);
        return $hash;
    }
}
