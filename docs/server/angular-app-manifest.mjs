
export default {
  bootstrap: () => import('./main.server.mjs').then(m => m.default),
  inlineCriticalCss: true,
  baseHref: './',
  locale: undefined,
  routes: [
  {
    "renderMode": 2,
    "redirectTo": "/home",
    "route": "/"
  },
  {
    "renderMode": 2,
    "route": "/home"
  },
  {
    "renderMode": 2,
    "route": "/registro"
  },
  {
    "renderMode": 2,
    "route": "/login"
  },
  {
    "renderMode": 2,
    "route": "/profesor"
  },
  {
    "renderMode": 2,
    "route": "/crearExamen"
  },
  {
    "renderMode": 2,
    "route": "/estudiante"
  },
  {
    "renderMode": 2,
    "route": "/resolver"
  }
],
  entryPointToBrowserMapping: undefined,
  assets: {
    'index.csr.html': {size: 492, hash: 'f3b72be32ffb0b029e41431c8a57aa8673af103ced3c37509e6fa140f78e5e5d', text: () => import('./assets-chunks/index_csr_html.mjs').then(m => m.default)},
    'index.server.html': {size: 1005, hash: 'bd07198e6884d729021f6d2e5bb16f17a0bd1328de60cc915ca03c0bb30ed649', text: () => import('./assets-chunks/index_server_html.mjs').then(m => m.default)},
    'registro/index.html': {size: 4371, hash: '0b9ce763402254e7a870cbc2defaeb09da09d128711ddbb04c62602a21ea56c3', text: () => import('./assets-chunks/registro_index_html.mjs').then(m => m.default)},
    'login/index.html': {size: 3322, hash: 'a3e2c224d55f21538157c2ff359e32049973cd783aa95018a66024427ae7e739', text: () => import('./assets-chunks/login_index_html.mjs').then(m => m.default)},
    'profesor/index.html': {size: 3431, hash: 'a59633fa83e68c227ac1cf0e610da15bd92cf9aedcf8fd9e9dbcfbc3e58ca242', text: () => import('./assets-chunks/profesor_index_html.mjs').then(m => m.default)},
    'crearExamen/index.html': {size: 7755, hash: '468f82865343e359326f811c167cc162a845c2649fe7cd71678561373278bb88', text: () => import('./assets-chunks/crearExamen_index_html.mjs').then(m => m.default)},
    'estudiante/index.html': {size: 3431, hash: 'ac4324154bc3f7e8e986def1202ac81135f16373c9b5b69770bec25512944e24', text: () => import('./assets-chunks/estudiante_index_html.mjs').then(m => m.default)},
    'resolver/index.html': {size: 4069, hash: '059228a58d8a294cb65885c0b690430038c03604ff5ec713ac3e4e032ff629d8', text: () => import('./assets-chunks/resolver_index_html.mjs').then(m => m.default)},
    'home/index.html': {size: 4368, hash: 'fd33d3c651acb1125259ce1ece3c667e02678890d62d2f29229d0ae064616071', text: () => import('./assets-chunks/home_index_html.mjs').then(m => m.default)},
    'styles-5INURTSO.css': {size: 0, hash: 'menYUTfbRu8', text: () => import('./assets-chunks/styles-5INURTSO_css.mjs').then(m => m.default)}
  },
};
