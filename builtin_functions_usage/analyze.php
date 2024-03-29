<?php

declare(strict_types=1);

use PhpParser\{Node, NodeTraverser, NodeVisitorAbstract};

require 'vendor/autoload.php';
require 'visitor.php';
require 'sensitivefunctionanalysis.php';

class AnalyzeBuiltinFunctionUsage {
    protected array $builtin_functions;
    protected string $target_dir;

    public function __construct($target_dir) {
        $this->builtin_functions = file('builtin_functions_usage/php_builtinfunctions.list', FILE_IGNORE_NEW_LINES);
        $this->target_dir = $target_dir;
    }

    public function extract_usage() {
        $this->builtin_functions = array_fill_keys($this->builtin_functions, 0);
         // For each file
        $files = AnalyzeBuiltinFunctionUsage::getDirContents($this->target_dir);
        foreach ($files as $key => $file_name) {
            if (array_key_exists('extension', pathinfo($file_name)) && (pathinfo($file_name)['extension'] == 'php')) {
                $code = file_get_contents($file_name);
                $parser = (new PhpParser\ParserFactory)->create(PhpParser\ParserFactory::PREFER_PHP5);
                try {
                    $ast = $parser->parse($code);
                    // var_dump($ast);
                    // return;
                } catch (PhpParser\Error $error) {
                    if (substr($code, 0, 4) === '<?hh') {
                        echo "Skipping HHVM file {$file_name}" . PHP_EOL;
                    }
                    else {
                        echo "Parse error at {$file_name}: {$error->getMessage()}" . PHP_EOL;
                    }
                }

                $traverser = new PhpParser\NodeTraverser;
                // Parse once to extract variable, function and class definitions
                $visitor = new Visitor($file_name, $this->builtin_functions);
                $traverser->addVisitor($visitor);
                $traverser->traverse($ast);
                $this->builtin_functions = $visitor->builtin_functions;
            }
        }
        arsort($this->builtin_functions);
        $result = array();
        $total = 0;
        foreach ($this->builtin_functions as $key => $value) {
            if ($value > 0) {
                $result[$key] = $value;
                $total++;
            }
        }
        echo $total.PHP_EOL;
        return $result;
    }

    public static function getDirContents($dir, &$results = array()) {
        $files = scandir($dir);
        foreach($files as $value){
            $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
            if (!$path) {
                // Directory not found or permission denied
                continue;
            }
            if(!is_dir($path)) {
                $results[] = $path;
            } else if($value != "." && $value != "..") {
                AnalyzeBuiltinFunctionUsage::getDirContents($path, $results);
                //$results[] = $path;
            }
        }

        return $results;
    }
}
$target_dir_1 = $argv[1];
$analyzer = new AnalyzeBuiltinFunctionUsage($target_dir_1);
$original_usage_results = $analyzer->extract_usage();



$sensitivefunc_analyzer = new SensitiveFunctionAnalysis();

$sensitivefunc_analyzer->append($original_usage_results);

echo $sensitivefunc_analyzer->command_execution_calls[0]  . PHP_EOL;
echo $sensitivefunc_analyzer->php_code_execution_calls[0]  . PHP_EOL;
echo $sensitivefunc_analyzer->callback_calls[0]. PHP_EOL;
echo $sensitivefunc_analyzer->information_disclosure_calls[0] . PHP_EOL;
echo $sensitivefunc_analyzer->other_calls[0]. PHP_EOL;
echo $sensitivefunc_analyzer->filesystem_calls[0] .PHP_EOL;