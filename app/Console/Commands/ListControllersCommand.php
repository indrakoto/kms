<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ReflectionClass;
use Illuminate\Support\Facades\File;

class ListControllersCommand extends Command
{
    protected $signature = 'list:controllers';
    protected $description = 'List all controllers and their methods';

    public function handle()
    {
        $controllersPath = app_path('Http/Controllers');
        $files = File::allFiles($controllersPath);
        
        $controllers = [];
        
        foreach ($files as $file) {
            $className = 'App\\Http\\Controllers\\' . str_replace(
                ['/', '.php'],
                ['\\', ''],
                $file->getRelativePathname()
            );
            
            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);
                $methods = [];
                
                foreach ($reflection->getMethods() as $method) {
                    if ($method->class === $className && $method->isPublic()) {
                        $methods[] = $method->name;
                    }
                }
                
                $controllers[$className] = $methods;
            }
        }
        
        $this->table(
            ['Controller', 'Methods'],
            array_map(
                fn ($ctrl, $methods) => [$ctrl, implode(', ', $methods)],
                array_keys($controllers),
                array_values($controllers)
            )
        );
        
        // Tambahkan di handle() method setelah mendapatkan data controllers
        $markdown = "# Daftar Controller dan Method\n\n";
        foreach ($controllers as $controller => $methods) {
            $markdown .= "## " . class_basename($controller) . "\n";
            $markdown .= "**Namespace:** `$controller`\n\n";
            $markdown .= "### Methods:\n";
            foreach ($methods as $method) {
                $markdown .= "- `$method()`\n";
            }
            $markdown .= "\n";
        }

        File::put(storage_path('app/controllers_documentation.md'), $markdown);
        $this->info('Documentation generated at: ' . storage_path('app/controllers_documentation.md'));
    }
}