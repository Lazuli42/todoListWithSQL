<?php
    /**
    *@backupGlobals disabled
    *@backupStaticAttributes disabled
    */

    require_once "src/Task.php";
    require_once "src/Category.php";
    //Server must reference local host on MAMP port.
    $server = 'mysql:host=localhost:8889;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO ($server, $username, $password);

    class TaskTest extends PHPUnit_Framework_TestCase
    {

        //NOTE: CLEAN UP DATABASE!!!
        protected function tearDown()
        {
            Task::deleteAll();
            Category::deleteAll();
        }

        function test_getID()
        {
            //ARRANGE
            $name = 'Home stuff';
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "wash the cat";

            $test_task = new Task($description, $id);
            $test_task->save();

            //ACT
            $result = $test_task->getID();

            //ASSERT
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //ARRANGE
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description ='wash the cat';

            $test_task = new Task($description, $id);
            //ACT
            $test_task->save();
            //ASSERT
            $result = Task::getAll();
            $this->assertEquals($test_task, $result[0]);
        }

        function test_getAll()
        {
            //ARRANGE
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description ='wash the cat';

            $test_task = new Task($description, $id);
            $test_task->save();

            $description2 ='wash the dog';
            $test_task2 = new Task($description2, $id);
            $test_task2->save();


            //ACT
            $result = Task::getAll();
            // var_dump($result);

            //ASSERT
            $this->assertEquals([$test_task, $test_task2], $result);
        }

        function test_deleteAll()
        {
            //ARRANGE
            $name = "Home stuff";
            $id = null;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description ='wash the cat';

            $test_task = new Task($description, $id);
            $test_task->save();

            $description2 ='wash the dog';
            $test_task2 = new Task($description2, $id);
            $test_task2->save();

            //ACT
            Task::deleteAll();

            //ASSERT
            $result = Task::getAll();
            $this->assertEquals([], $result);
        }

        // function test_find()
        // {
        //     //ARRANGE
        //     $name = "Home stuff";
        //     $id = null;
        //     $test_category = new Category($name, $id);
        //     $test_category->save();
        //
        //     $description ='wash the cat';
        //
        //     $test_task = new Task($description, $id);
        //     $test_task->save();
        //
        //     $description2 ='wash the dog';
        //     $test_task2 = new Task($description2, $id);
        //     $test_task2->save();
        //
        //     //ACT
        //     $result = Task::find($test_task->getID());
        //
        //     //ASSERT
        //     $this->assertEquals($test_task, $result);
        // }

        function testAddCategory()
        {
            //ARRANGE
            $name = "Medical";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Perform Surgery";
            $id2 = 2;
            $test_task = new Task($description, $id2);
            $test_task->save();

            //ACT
            $test_task->addCategory($test_category);

            //ASSERT
            $this->assertEquals($test_task->getCategories(), [$test_category]);
        }

        function testGetCategories()
        {
            //ARRANGE
            $name = "Medical";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $name2 = "Surgery";
            $id2 = 2;
            $test_category2 = new Category($name2, $id2);
            $test_category2->save();

            $description = "Perform Surgery";
            $id3 = 3;
            $test_task = new Task($description, $id3);
            $test_task->save();

            //ACT
            $test_task->addCategory($test_category);
            $test_task->addCategory($test_category2);

            //ASSERT
            $this->assertEquals($test_task->getCategories(), [$test_category, $test_category2]);
        }

        function testDelete()
        {
            //ARRANGE
            $name = "Medical";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Perform Surgery";
            $id3 = 3;
            $test_task = new Task($description, $id3);
            $test_task->save();
            $test_task->addCategory($test_category);

            //ACT
            $test_task->delete();

            //ASSERT
            $this->assertEquals([], $test_category->getTasks());
        }
    }
?>
