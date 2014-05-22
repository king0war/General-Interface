General-Interface
=================

Build an interface / web hook between 2 or more  program fastly &amp; safety

Instructions for use

Principle: Sender - > Data package - > Send - > acceptance procedures - > unzip - > Run
Execution : gi_notice.php-> client.php
Encryption: There are two encryption methods , 1 dz classical encryption two simple encryption
Parameter Description :
1, the method name the recipient needs to perform action
2, data other data needs to be transmitted
Usage:
1 , notice the use of the method , see demo.php
2 , the use of the recipient
Edit  gi_exec.php program automatically execute action method

Configuration instructions
Configuration file : config.php
define ('GI_KEY', '* (<% $ #.'); / / encryption key
define ('GI_PATH', dirname (__FILE__)); / / root directory
define ('GI_CHAR', 'GBK'); / / Program Character Set
define ('GI_TIMEOUT', 200); / / expiration time , unit: seconds
define ('GI_PARAMS_ARRAY', false); / / parameter is used array package
true data is passed to the array to action method
Testing .. Params:
Array ([0] => Array ([0] => I'm parameters [1 ] = > The second parameter ) )
false data passed as a parameter to the action method
Testing .. Params:
Array ([0] => I'm parameters [1 ] = > The second parameter )
$ whiteList = array ('get', 'post', 'put', 'delete', 'test'); / / method can be called white list

Test Method : test
Returns: the received parameters

Use Scene
 * Quick to realize the needs of specific scenarios .
 * Use Scenario 1 : Implementing Security Interface
 * Use Scene 2: A, B to perform some action needs to be synchronized . . .
 * Use Scene 3: A, B need to share user information
 * Solution a: Database master-slave synchronization advantages: highly consistent data Disadvantages : Configuration cumbersome database overhead increases
 * Solution b: ucenter Advantages : Fast , used almost every uc cms plugin Disadvantages: fixed function , if one wants to achieve special functions ( synchronous registration, etc. ) need to uc secondary development
 * Solution c: gi advantages: flexible, easy to implement various functions Disadvantages: need to develop their own . . . .
