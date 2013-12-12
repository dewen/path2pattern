Pattern-Matching Paths Project
==============================================

Usage:

    []$ ./process.php < data/input > data/output

Unittest:

    Covers some basic edges cases. 

    []$ phpunit test

Performance test:

    Create the long path list with script for testing:

    []$ php script/create_test_data.php 1000


Files

    .
    ├── data
    │   ├── input
    │   └── output
    ├── Match.class.php
    ├── Path.class.php
    ├── Pattern.class.php
    ├── process.php
    ├── README.md
    ├── script
    │   └── create_test_data.php
    └── test
        ├── init.php
        ├── MatchTest.php
        ├── PathTest.php
        └── PatternTest.php
