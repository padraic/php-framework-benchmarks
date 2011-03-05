package c5_8::View::HTML;

use strict;
use warnings;

use base 'Catalyst::View::TT';

__PACKAGE__->config(
    TEMPLATE_EXTENSION => '.tt',
    render_die => 1,
);

=head1 NAME

c5_8::View::HTML - TT View for c5_8

=head1 DESCRIPTION

TT View for c5_8.

=head1 SEE ALSO

L<c5_8>

=head1 AUTHOR

Padraic Brady,,,

=head1 LICENSE

This library is free software. You can redistribute it and/or modify
it under the same terms as Perl itself.

=cut

1;
