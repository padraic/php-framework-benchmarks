package c5_8::Controller::Hello;
use Moose;
use namespace::autoclean;

BEGIN {extends 'Catalyst::Controller'; }

=head1 NAME

c5_8::Controller::Hello - Catalyst Controller

=head1 DESCRIPTION

Catalyst Controller.

=head1 METHODS

=cut


=head2 index

=cut

sub index :Path :Args(0) {
    my ( $self, $c ) = @_;

    $c->response->body('Matched c5_8::Controller::Hello in Hello.');
}

sub world :Local {
    my ( $self, $c ) = @_;
    $c->stash(template => 'hello.tt');
}


=head1 AUTHOR

Padraic Brady,,,

=head1 LICENSE

This library is free software. You can redistribute it and/or modify
it under the same terms as Perl itself.

=cut

__PACKAGE__->meta->make_immutable;

1;

