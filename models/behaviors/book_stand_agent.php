<?php
class BookStandAgentBehaviorForOverride extends ModelBehavior {
	
}

// Override
if ($behaviors = Configure::read('BookStand.override.behaviors')) {
	App::import('Behavior' ,$behaviors);
} else {
	class BookStandAgentBehavior extends BookStandAgentBehaviorForOverride {}
}
