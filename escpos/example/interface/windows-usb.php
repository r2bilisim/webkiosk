<?php
	/* Change to the correct path if you copy this example! */
require __DIR__ . '/../../autoload.php';
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

/**
 * Install the printer using USB printing support, and the "Generic / Text Only" driver,
 * then share it (you can use a firewall so that it can only be seen locally).
 *
 * Use a WindowsPrintConnector with the share name to print.
 *
 * Troubleshooting: Fire up a command prompt, and ensure that (if your printer is shared as
 * "Receipt Printer), the following commands work:
 *
 *  echo "Hello World" > testfile
 *  copy testfile "\\%COMPUTERNAME%\Receipt Printer"
 *  del testfile
 */
 if(isset($_POST['test']))
 {
	$mesaj=htmlspecialchars($_POST['test'])."\n";
}
try {
    // Enter the share name for your USB printer here
    //$connector = null;
    $connector = new WindowsPrintConnector("XP-80C");

    /* Print a "Hello world" receipt" */
    $printer = new Printer($connector);
	/*
		int $widthMultiplier: Multiple of the regular height to use (range 1 - 8).
		int $heightMultiplier: Multiple of the regular height to use (range 1 - 8).
	*/
    //$printer -> setTextSize(4, 5);
    $printer -> text($mesaj);

    $printer -> cut();
    
    /* Close printer */
    $printer -> close();
} catch (Exception $e) {
    echo "Couldn't print to this printer: " . $e -> getMessage() . "\n";
}
