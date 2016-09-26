<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Category.php";
    require_once "src/Task.php";

    $server = 'mysql:host=localhost:8889;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CategoryTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
          Category::deleteAll();
          Task::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Work stuff";
            $test_Category = new Category($name);

            //Act
            $result = $test_Category->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_Category = new Category($name, $id);

            //Act
            $result = $test_Category->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_Category = new Category($name, $id);
            $test_Category->save();

            //Act
            $result = Category::getAll();

            //Assert
            $this->assertEquals($test_Category, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Work stuff";
            $name2 = "Home stuff";
            $test_Category = new Category($name);
            $test_Category->save();
            $test_Category2 = new Category($name2);
            $test_Category2->save();

            //Act
            $result = Category::getAll();

            //Assert
            $this->assertEquals([$test_Category, $test_Category2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Work Stuff";
            $name2 = "Home stuff";
            $test_Category = new Category($name);
            $test_Category->save();
            $test_Category2 = new Category($name2);
            $test_Category2->save();

            //Act
            Category::deleteAll();
            $result = Category::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Work Stuff";
            $name2 = "Home stuff";
            $test_Category = new Category($name);
            $test_Category->save();
            $test_Category2 = new Category($name2);
            $test_Category2->save();

            //Act
            $result = Category::find($test_Category->getId());

            //Assert
            $this->assertEquals($test_Category, $result);
        }

        function testAddTasks() {
            //ARRANGE
            $name = "Cool Stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Do cool stuff";
            $id2 = 2;
            $test_task = new Task($description, $id2);
            $test_task->save();

            //ACT
            $test_category->addTask($test_task);

            //ASSERT
            $this->assertEquals($test_category->getTasks(), [$test_task]);
        }

        function test_getTasks()
        {
            // Arrange
            $name = "cool stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "pull a radical stunt";
            $test_task = new Task($description, $id);
            $test_task->save();
            $test_category->addTask($test_task);

            $description2 = "donate to charity";
            $id2 = 2;
            $test_task2 = new Task($description2, $id2);
            $test_task2->save();
            $test_category->addTask($test_task2);

            // Act
            $result = $test_category->getTasks();

            // Assert
            $this->assertEquals([$test_task, $test_task2], $result);
        }

        function testDelete()
        {
            //ARRANGE
            $name = "cool stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "pull a radical stunt";
            $test_task = new Task($description, $id);
            $test_task->save();
            $test_category->addTask($test_task);

            //ACT
            $test_category->delete();

            //ASSERT
            $this->assertEquals([], $test_task->getCategories());
        }
    }

?>
