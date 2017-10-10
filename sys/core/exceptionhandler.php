<?php

class ExceptionHandler extends ErrorException {

    /**
     * printException
     * @access	public
     */
    public static function printException(Exception $e) {
        $getCode = $e->getCode();
        $code_name = array(
            'E_ERROR' => 'E_ERROR',
            'E_WARNING' => 'E_WARNING',
            'E_PARSE' => 'E_PARSE',
            'E_NOTICE' => 'E_NOTICE',
            'E_CORE_ERROR' => 'E_CORE_ERROR',
            'E_CORE_WARNING' => 'E_CORE_WARNING',
            'E_COMPILE_ERROR' => 'E_COMPILE_ERROR',
            'E_COMPILE_WARNING' => 'E_COMPILE_WARNING',
            'E_USER_ERROR' => 'E_USER_ERROR',
            'E_USER_WARNING' => 'E_USER_WARNING',
            'E_USER_NOTICE' => 'E_USER_NOTICE',
            'E_STRICT' => 'E_STRICT',
            'E_RECOVERABLE_ERROR' => 'E_RECOVERABLE_ERROR',
            $getCode => $getCode
        );
        self::printExceptionHTML($code_name[$getCode], $e->getMessage(), $e->getFile(), $e->getLine());
    }

    /**
     * printException
     * @access	public
     */
    public static function printExceptionHTML($code_name, $getMessage, $getFile, $getLine) {
        ?>
        <span style="text-align: left; background-color: #ffb0b0; border: #ffb0b0 1px solid; color: #000000; display: block; margin: .5%; padding: .5%">
            <b>[Error Number] Message :</b> [<?= $code_name ?>] <?= $getMessage; ?><br/>
            <b>[Line Number] File Name:</b> [<?= $getLine; ?>] <?= $getFile; ?><br/>
        </span>
        <?php
    }

    /**
     * handleException
     * @access	public
     */
    public static function handleException(Exception $e) {
        return self::printException($e);
    }

}
