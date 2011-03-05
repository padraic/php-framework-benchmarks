from django.template import Context, loader
from django.http import HttpResponse

def index(request):
    t = loader.get_template('hello/index.html')
    c = Context({
        'name': 'Paddy',
    })
    return HttpResponse(t.render(c))

