<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="CalculadoraRPN.css">
	<title>RPN</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <?php
        session_start();
        
        define('SYNTAX_ERROR', 'Syntax error');
        
        class RPNCalculator
        {
            protected $memory;
            protected $display;
            protected $displayLines;
            protected $stack;

            public function __construct()
            {
                $this->clear();
                $this->displayLines =
                    array('', '', '', '', '');
                $this->stack = new Stack();
            }

            public function getDisplay()
            {
                return $this->display;
            }

            public function getLine($i)
            {
                return $this->displayLines[$i];
            }

            // Stack lines
            private function updateDisplay()
            {
                $size = $this->stack->size();
        
                for ($i = 0; $i < 5; $i++) {
                    if ($size - 1 - $i < 0) {
                        $this->displayLines[$i] = '';
                    } elseif ($this->stack->search($size - 1 - $i) == '') {
                        $this->displayLines[$i] = '';
                    } else {
                        $this->displayLines[$i] = $this->stack->search($size - 1 - $i);
                    }
                }
            }

            public function enter()
            {
                try {
                    eval("\$this->stack->push(\$this->display);");
                } catch (Error $e) {
                    $this->display = SYNTAX_ERROR;
                }
                $this->updateDisplay();
                $this->display = '0';
            }

            public function removeLine()
            {
                $this->stack->pop();
                $this->updateDisplay();
            }

            private function singleLineOperation($operation)
            {
                if ($this->stack->size() >= 1) {
                    $this->stack->push($operation($this->stack->pop()));
                    $this->updateDisplay();
                }
            }
        
            private function doubleLineOperation($operation)
            {
                if ($this->stack->size() >= 2) {
                    $b = $this->stack->pop();
                    $a = $this->stack->pop();
                    $this->stack->push($operation($a, $b));
                    $this->updateDisplay();
                }
            }

            // Operations
            public function addition()
            {
                $this->doubleLineOperation(function ($op1, $op2) {
                    return $op1 + $op2;
                });
            }
            
            public function subtraction()
            {
                $this->doubleLineOperation(function ($op1, $op2) {
                    return $op1 - $op2;
                });
            }
            
            public function multiplication()
            {
                $this->doubleLineOperation(function ($op1, $op2) {
                    return $op1 * $op2;
                });
            }
            
            public function division()
            {
                $this->doubleLineOperation(function ($op1, $op2) {
                    return $op1 / $op2;
                });
            }

            public function random()
            {
                $this->display = strval(rand(0, 1000000) / 1000000);
            }

            public function pi()
            {
                $this->display = pi();
            }

            public function invert()
            {
                $this->singleLineOperation(function ($op) {
                    return $op ** -1;
                });
            }

            public function invertSign()
            {
                $this->singleLineOperation(function ($op) {
                    return $op * -1;
                });
            }

            public function factorial()
            {
                $this->singleLineOperation(function ($op) {
                    $factorial = 1;
                    for ($x = $op; $x >= 1; $x--) {
                        $factorial = $factorial * $x;
                    }
                    return $factorial;
                });
            }

            public function sine()
            {
                $this->singleLineOperation(function ($op) {
                    return sin($op);
                });
            }

            public function cosine()
            {
                $this->singleLineOperation(function ($op) {
                    return cos($op);
                });
            }

            public function tangent()
            {
                $this->singleLineOperation(function ($op) {
                    return tan($op);
                });
            }

            public function squareRoot()
            {
                $this->singleLineOperation(function ($op) {
                    return sqrt($op);
                });
            }

            public function logarithm()
            {
                $this->singleLineOperation(function ($op) {
                    return log10($op);
                });
            }

            public function naturalLogarithm()
            {
                $this->singleLineOperation(function ($op) {
                    return log($op);
                });
            }

            public function exp()
            {
                $this->doubleLineOperation(function ($op1, $op2) {
                    return $op1 ** $op2;
                });
            }

            // Symbols
            public function number($number)
            {
                if ($this->display == '0') {
                    $this->display = '';
                }

                $this->display .= $number;
            }

            public function comma()
            {
                $this->display .= '.';
            }

            // Other
            public function clear()
            {
                $this->display = '0';
            }

            public function clearOne()
            {
                if (strlen($this->display) > 1) {
                    $this->display = substr($this->display, 0, -1);
                } else {
                    $this->display = '0';
                }
            }
        }

        class Stack
        {
            protected $array = array();

            public function push($element)
            {
                array_push($this->array, $element);
            }

            public function pop()
            {
                return array_pop($this->array);
            }

            public function peek()
            {
                return end($this->array);
            }

            public function empty()
            {
                $this->array = array();
            }

            public function search($index)
            {
                try {
                    return $this->array[$index];
                } catch (Exception $e) {
                    return null;
                }
            }

            public function size()
            {
                return count($this->array);
            }
        }

        function alert($message)
        {
            echo "<script>alert('" . $message . "')</script>";
        }

        if (!isset($_SESSION['rpnCalculator'])) {
            $_SESSION['rpnCalculator'] = new RPNCalculator();
        }
        if (isset($_POST['memRecovery'])) {
            $_SESSION['rpnCalculator']->memRecovery();
        }
        if (isset($_POST['memPlus'])) {
            $_SESSION['rpnCalculator']->memPlus();
        }
        if (isset($_POST['memMinus'])) {
            $_SESSION['rpnCalculator']->memMinus();
        }
        if (isset($_POST['memIn'])) {
            $_SESSION['rpnCalculator']->memIn();
        }
        if (isset($_POST['memOut'])) {
            $_SESSION['rpnCalculator']->memOut();
        }

        if (isset($_POST['addition'])) {
            $_SESSION['rpnCalculator']->addition();
        }
        if (isset($_POST['subtraction'])) {
            $_SESSION['rpnCalculator']->subtraction();
        }
        if (isset($_POST['multiplication'])) {
            $_SESSION['rpnCalculator']->multiplication();
        }
        if (isset($_POST['division'])) {
            $_SESSION['rpnCalculator']->division();
        }
        if (isset($_POST['invertSign'])) {
            $_SESSION['rpnCalculator']->invertSign();
        }
        if (isset($_POST['squareRoot'])) {
            $_SESSION['rpnCalculator']->squareRoot();
        }
        if (isset($_POST['sine'])) {
            $_SESSION['rpnCalculator']->sine();
        }
        if (isset($_POST['cosine'])) {
            $_SESSION['rpnCalculator']->cosine();
        }
        if (isset($_POST['tangent'])) {
            $_SESSION['rpnCalculator']->tangent();
        }
        if (isset($_POST['factorial'])) {
            $_SESSION['rpnCalculator']->factorial();
        }
        if (isset($_POST['invert'])) {
            $_SESSION['rpnCalculator']->invert();
        }
        if (isset($_POST['random'])) {
            $_SESSION['rpnCalculator']->random();
        }
        if (isset($_POST['logarithm'])) {
            $_SESSION['rpnCalculator']->logarithm();
        }
        if (isset($_POST['naturalLogarithm'])) {
            $_SESSION['rpnCalculator']->naturalLogarithm();
        }
        if (isset($_POST['pi'])) {
            $_SESSION['rpnCalculator']->pi();
        }
        if (isset($_POST['exp'])) {
            $_SESSION['rpnCalculator']->exp();
        }

        if (isset($_POST['number0'])) {
            $_SESSION['rpnCalculator']->number('0');
        }
        if (isset($_POST['number1'])) {
            $_SESSION['rpnCalculator']->number('1');
        }
        if (isset($_POST['number2'])) {
            $_SESSION['rpnCalculator']->number('2');
        }
        if (isset($_POST['number3'])) {
            $_SESSION['rpnCalculator']->number('3');
        }
        if (isset($_POST['number4'])) {
            $_SESSION['rpnCalculator']->number('4');
        }
        if (isset($_POST['number5'])) {
            $_SESSION['rpnCalculator']->number('5');
        }
        if (isset($_POST['number6'])) {
            $_SESSION['rpnCalculator']->number('6');
        }
        if (isset($_POST['number7'])) {
            $_SESSION['rpnCalculator']->number('7');
        }
        if (isset($_POST['number8'])) {
            $_SESSION['rpnCalculator']->number('8');
        }
        if (isset($_POST['number9'])) {
            $_SESSION['rpnCalculator']->number('9');
        }

        if (isset($_POST['comma'])) {
            $_SESSION['rpnCalculator']->comma();
        }

        if (isset($_POST['clear'])) {
            $_SESSION['rpnCalculator']->clear();
        }
        if (isset($_POST['clearOne'])) {
            $_SESSION['rpnCalculator']->clearOne();
        }
        if (isset($_POST['equals'])) {
            $_SESSION['rpnCalculator']->equals();
        }

        if (isset($_POST['enter'])) {
            $_SESSION['rpnCalculator']->enter();
        }
        if (isset($_POST['removeLine'])) {
            $_SESSION['rpnCalculator']->removeLine();
        }
    ?>

    <h1>Calculadora RPN</h1>
    <main class="calculator">
        <div class="stackDisplay" id="stackDisplay">
            <label class="lineNumber" for="line5">5:</label>
            <input type="text" class="stackLine" id="line5"
                value="<?php echo $_SESSION['rpnCalculator']->getLine(4); ?>" disabled>

            <label class="lineNumber" for="line4">4:</label>
            <input type="text" class="stackLine" id="line4"
                value="<?php echo $_SESSION['rpnCalculator']->getLine(3); ?>" disabled>

            <label class="lineNumber" for="line3">3:</label>
            <input type="text" class="stackLine" id="line3"
                value="<?php echo $_SESSION['rpnCalculator']->getLine(2); ?>" disabled>

            <label class="lineNumber" for="line2">2:</label>
            <input type="text" class="stackLine" id="line2"
                value="<?php echo $_SESSION['rpnCalculator']->getLine(1); ?>" disabled>

            <label class="lineNumber" for="line1">1:</label>
            <input type="text" class="stackLine" id="line1"
                value="<?php echo $_SESSION['rpnCalculator']->getLine(0); ?>" disabled>
        </div>
        <label for="display" hidden>Pantalla</label>
        <input type="text" id="display" value="<?php echo $_SESSION['rpnCalculator']->getDisplay(); ?>" disabled/>
        <form action="#" method="post" class="functionButtons">
            <input type="submit" name="altOn" value="alt" class="altButtonOff altOff">
            <input type="submit" name="logarithm" value="log" class="blueButton altOff">
            <input type="submit" name="naturalLogarithm" value="ln" class="blueButton altOff">
            <input type="submit" name="pi" value="π" class="blueButton altOff">

            <input type="submit" name="random" value="rand" class="blueButton">
            <input type="submit" name="invert" value="1/x" class="blueButton">
            <input type="submit" name="factorial" value="x!" class="blueButton">
            <input type="submit" name="sine" value="sin" class="blueButton altOff">
            <input type="submit" name="cosine" value="cos" class="blueButton altOff">
            <input type="submit" name="tangent" value="tan" class="blueButton altOff">

            <input type="submit" name="invertSign" value="+/-" class="blueButton">
            <input type="submit" name="squareRoot" value="sqrt" class="blueButton altOff">
        </form>
        <form action="#" method="post" class="basicButtons">
            <input type="submit" name="number7" value="7" class="whiteButton">
            <input type="submit" name="number8" value="8" class="whiteButton">
            <input type="submit" name="number9" value="9" class="whiteButton">
            <input type="submit" name="clearOne" value="C" class="redButton">
            <input type="submit" name="clear" value="AC" class="redButton">

            <input type="submit" name="number4" value="4" class="whiteButton">
            <input type="submit" name="number5" value="5" class="whiteButton">
            <input type="submit" name="number6" value="6" class="whiteButton">
            <input type="submit" name="multiplication" value="*" class="greyButton">
            <input type="submit" name="division" value="/" class="greyButton">

            <input type="submit" name="number1" value="1" class="whiteButton">
            <input type="submit" name="number2" value="2" class="whiteButton">
            <input type="submit" name="number3" value="3" class="whiteButton">
            <input type="submit" name="addition" value="+" class="greyButton">
            <input type="submit" name="subtraction" value="-" class="greyButton">

            <input type="submit" name="number0" value="0" class="whiteButton">
            <input type="submit" name="comma" value="." class="whiteButton">
            <input type="submit" name="exp" value="exp" class="greyButton">
            <input type="submit" name="enter" value="ENTER" class="stackButton">
            <input type="submit" name="removeLine" value="DEL" class="stackButton">
        </form>
    </main>
</body>
</html>