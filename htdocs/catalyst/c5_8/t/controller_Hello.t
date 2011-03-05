use strict;
use warnings;
use Test::More;

BEGIN { use_ok 'Catalyst::Test', 'c5_8' }
BEGIN { use_ok 'c5_8::Controller::Hello' }

ok( request('/hello')->is_success, 'Request should succeed' );
done_testing();
