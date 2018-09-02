<?php

    namespace rAPId\Tests;


    use rAPId\Debug\ServerLog;
    use rAPId\Exceptions\Exception;

    class ServerLogTest extends TestCase
    {
        protected $log_dir = 'logs/';

        /**
         * Remove the logs that were generated by these tests
         */
        public function tearDown() {
            if (is_dir($this->log_dir) && $dir_handle = opendir($this->log_dir)) {
                while (($entry = readdir($dir_handle)) !== false) {
                    if (!in_array($entry, ['.', '..'])) {
                        unlink($this->log_dir . $entry);
                    }
                }
                rmdir($this->log_dir);
            }
            parent::tearDown();
        }

        function testDefaultErrorHandlerAddedByBootstrap() {
            $error_handler = set_error_handler(null);
            $this->assertEquals([ServerLog::class, 'logError'], $error_handler);
        }

        function testDefaultExceptionHandlerAddedByBootstrap() {
            $exception_handler = set_exception_handler(null);
            $this->assertEquals([ServerLog::class, 'logException'], $exception_handler);
        }

        function testErrorHandlerGeneratesLogFile() {
            $this->assertDirectoryNotExists($this->log_dir);
            ServerLog::logError(123, 'test error', 'test file', 1234);
            $this->assertDirectoryExists($this->log_dir);
            $this->assertFileExists($this->log_dir . date('Y-m-d') . '.txt');
        }

        function testErrorHandlerDescribesError() {
            $test_error = 'TEST ERROR MESSAGE';
            ServerLog::logError(123, $test_error, 'test file', 1234);
            $log_file_contents = file_get_contents($this->log_dir . date('Y-m-d') . '.txt');
            $this->assertContains($test_error, $log_file_contents, 'Expected error to appear in log file');
        }

        function testExceptionHandlerGeneratesLogFile() {
            $this->assertDirectoryNotExists($this->log_dir);
            ServerLog::logException(new Exception('Test Exception!'));
            $this->assertFileExists($this->log_dir . date('Y-m-d') . '.txt');
        }

        function testExceptionHandlerDescribesError() {
            $test_exception_message = 'TEST ERROR MESSAGE';
            ServerLog::logException(new Exception($test_exception_message));
            $log_file_contents = file_get_contents($this->log_dir . date('Y-m-d') . '.txt');
            $this->assertContains($test_exception_message, $log_file_contents, 'Expected exception message to appear in log file');
        }
    }