# JSON Compareing

You can use the class Jsoncomparer to compare two JSON file, two JSON Object or two directry with JSON files. It is build on top of library called TreeWalker by Licas Cordeiro Da Silva.

## How to use it
```require_once "Jsoncomparer.php";

// Creating the Object
$jc = new Jsoncomparer(["debug" => true, "returntype" => "jsonstring"]);

// Set ouput directory [Optional]
$jc->setOutputDirectory('some-dir2');

// Compare just two files
$jc->compareFile('new_data/data1.json', 'org_data/data1.json');

// Compare just two json object
$json1 = file_get_contents('new_data/data1.json');
$json2 = file_get_contents('org_data/data1.json');

$jc->compareObject($json1, $json2);

// Compare directories
$jc->compareDirectories('org_data', 'new_data');```

Hope this helped you!
