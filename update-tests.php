<?php

$dir = new RecursiveDirectoryIterator(__DIR__ . '/tests');
$iter = new RecursiveIteratorIterator($dir);

foreach ($iter as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $path = $file->getPathname();
        $code = file_get_contents($path);

        // Reemplaza cualquier doc-comment con @test por #[Test]
        $newCode = preg_replace('/\/\*\* *@test *\*\//', '#[Test]', $code);
        $newCode = preg_replace('/\/\*\*@test\*\//', '#[Test]', $newCode);
        $newCode = preg_replace('/\/\*\s*@test\s*\*\//', '#[Test]', $newCode);

        if ($newCode !== $code) {
            file_put_contents($path, $newCode);
            echo "Actualizado: $path\n";
        }
    }
}

echo "✅ Todos los tests actualizados a #[Test]\n";
