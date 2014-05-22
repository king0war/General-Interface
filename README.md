General-Interface
=================
<br/>
<br/>Build an interface / web hook between 2 or more  program fastly &amp; safety
<br/>
<br/>Instructions for use
<br/>
<br/>Principle: Sender - > Data package - > Send - > acceptance procedures - > unzip - > Run
<br/>Execution : gi_notice.php-> client.php
<br/>Encryption: There are two encryption methods , 1 dz classical encryption two simple encryption
<br/>Parameter Description :
<br/>1, the method name the recipient needs to perform action
<br/>2, data other data needs to be transmitted
<br/>Usage:
<br/>1 , notice the use of the method , see demo.php
<br/>2 , the use of the recipient
<br/>Edit  gi_exec.php program automatically execute action method
<br/>
<br/>Configuration instructions
<br/>Configuration file : config.php
<br/>define ('GI_KEY', '* (<% $ #.'); // encryption key
<br/>define ('GI_PATH', dirname (__FILE__)); // root directory
<br/>define ('GI_CHAR', 'GBK'); // Program Character Set
<br/>define ('GI_TIMEOUT', 200); // expiration time , unit: seconds
<br/>define ('GI_PARAMS_ARRAY', false); // parameter is used array package
<br/>true data is passed to the array to action method
<br/>Testing .. Params:
<br/>Array ([0] => Array ([0] => I'm parameters [1 ] = > The second parameter ) )
<br/>false data passed as a parameter to the action method
<br/>Testing .. Params:
<br/>Array ([0] => I'm parameters [1 ] = > The second parameter )
<br/>$ whiteList = array ('get', 'post', 'put', 'delete', 'test'); // method can be called white list
<br/>
<br/>Test Method : test
<br/>Returns: the received parameters
<br/>
<br/>Use Scene
<br/> * Quick to realize the needs of specific scenarios .
<br/> * Use Scenario 1 : Implementing Security Interface
<br/> * Use Scene 2: A, B to perform some action needs to be synchronized . . .
<br/> * Use Scene 3: A, B need to share user information
<br/> * Solution a: Database master-slave synchronization advantages: highly consistent data Disadvantages : Configuration cumbersome database overhead increases
<br/> * Solution b: ucenter Advantages : Fast , used almost every uc cms plugin Disadvantages: fixed function , if one wants to achieve special functions ( synchronous registration, etc. ) need to uc secondary development
<br/> * Solution c: gi advantages: flexible, easy to implement various functions Disadvantages: need to develop their own . . . .
<br/>
