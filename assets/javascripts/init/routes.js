// routes
var routes = new anyroutes();

routes.before(unflr.init.ready)
.any('/', unflr.root.ready)
;
