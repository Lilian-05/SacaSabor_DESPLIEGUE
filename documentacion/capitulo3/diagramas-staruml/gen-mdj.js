// Generador de proyecto StarUML (.mdj) para SacaSabor - Capítulo III
const fs = require('fs');

let counter = 0;
const id = () => 'ID' + String(++counter).padStart(6, '0');

const byId = {};
function el(type, parent, name, extra = {}) {
  const base = { _type: type, _id: id(), _parent: { $ref: parent }, name };
  if (/Model$|Package$|Diagram$|Interaction$|Activity$/.test(type)) { base.ownedElements = []; base.ownedViews = []; }
  Object.assign(base, extra);
  byId[base._id] = base;
  return base;
}
function view(type, diagramId, modelId, x, y, w, h, extra = {}) {
  return Object.assign(
    { _type: type, _id: id(), _parent: { $ref: diagramId }, model: { $ref: modelId }, x, y, width: w, height: h },
    extra
  );
}
function edgeView(type, diagramId, modelId, srcView, tgtView, points, extra = {}) {
  return Object.assign(
    { _type: type, _id: id(), _parent: { $ref: diagramId }, model: { $ref: modelId },
      tail: { $ref: srcView }, head: { $ref: tgtView }, points: points },
    extra
  );
}
function assocModel(t1, t2) {
  const asId = id();
  const as = {
    _type: 'UMLAssociation', _id: asId, _parent: { $ref: t1 }, name: '',
    end1: { _type: 'UMLAssociationEnd', _id: id(), _parent: { $ref: asId }, name: '', navigable: 'unspecified', aggregation: 'none', multiplicity: '', reference: { $ref: t1 }, qualifiers: [] },
    end2: { _type: 'UMLAssociationEnd', _id: id(), _parent: { $ref: asId }, name: '', navigable: 'unspecified', aggregation: 'none', multiplicity: '', reference: { $ref: t2 }, qualifiers: [] }
  };
  const owner = byId[t1];
  if (owner) { if (!owner.ownedElements) owner.ownedElements = []; owner.ownedElements.push(as); }
  return as;
}

const project = {
  _type: 'Project',
  _id: 'PROJECT',
  name: 'SacaSabor - Capitulo III',
  ownedElements: [],
  documentVersion: 1
};

const root = el('UMLModel', 'PROJECT', 'SacaSabor');
project.ownedElements.push(root);

function newDiagram(type, name) {
  const d = el(type, root._id, name, { ownedViews: [] });
  root.ownedElements.push(d);
  return d;
}
function add(d, v) { d.ownedViews.push(v); return v; }

// ============ MODELO COMÚN ============
// Actores
const pkg = el('UMLPackage', root._id, 'Dominio SacaSabor');
root.ownedElements.push(pkg);

const actorCliente = el('UMLActor', pkg._id, 'Cliente');
const actorPropietario = el('UMLActor', pkg._id, 'Propietario');
const actorAdmin = el('UMLActor', pkg._id, 'Administrador');
pkg.ownedElements.push(actorCliente, actorPropietario, actorAdmin);

const ucNames = [
  'Iniciar Sesión', 'Registrarse', 'Cerrar Sesión',
  'Buscar Chicharronerías', 'Filtrar por Zona y Categoría', 'Ver Detalle de Chicharronería',
  'Ver Menú y Productos', 'Ver Ubicación en Mapa', 'Calificar con Estrellas',
  'Escribir Comentario', 'Eliminar su Comentario', 'Ver Páginas Institucionales',
  'Enviar Mensaje de Contacto',
  'Registrar su Chicharronería', 'Editar Datos de su Chicharronería',
  'Gestionar Ubicación', 'Gestionar Productos', 'Cambiar Disponibilidad',
  'Ver Dashboard del Propietario', 'Editar su Perfil',
  'Gestionar Usuarios', 'Gestionar Chicharronerías', 'Eliminar Productos y Comentarios',
  'Gestionar Categorías', 'Ver Estadísticas', 'Consultar API REST'
];
const ucs = {};
ucNames.forEach(n => { ucs[n] = el('UMLUseCase', pkg._id, n); pkg.ownedElements.push(ucs[n]); });

// ============ D1: ACTORES ============
{
  const d = newDiagram('UMLUseCaseDiagram', 'Actores del Sistema');
  const sys = el('UMLClass', pkg._id, 'Sistema SacaSabor'); pkg.ownedElements.push(sys);
  const a1 = add(d, view('UMLActorView', d._id, actorCliente._id, 60, 120, 44, 70));
  const a2 = add(d, view('UMLActorView', d._id, actorPropietario._id, 60, 280, 44, 70));
  const a3 = add(d, view('UMLActorView', d._id, actorAdmin._id, 60, 440, 44, 70));
  add(d, view('UMLUseCaseSubjectView', d._id, sys._id, 200, 60, 720, 540));
  const pairs = [
    [actorCliente, 'Buscar Chicharronerías'], [actorCliente, 'Ver Menú y Productos'],
    [actorCliente, 'Calificar con Estrellas'], [actorCliente, 'Escribir Comentario'],
    [actorPropietario, 'Registrar su Chicharronería'], [actorPropietario, 'Gestionar Productos'],
    [actorPropietario, 'Cambiar Disponibilidad'], [actorPropietario, 'Gestionar Ubicación'],
    [actorAdmin, 'Gestionar Usuarios'], [actorAdmin, 'Gestionar Chicharronerías'],
    [actorAdmin, 'Gestionar Categorías'], [actorAdmin, 'Ver Estadísticas']
  ];
  let y = 90;
  const ucViews = {};
  pairs.forEach(([a, u]) => {
    const v = add(d, view('UMLUseCaseView', d._id, ucs[u]._id, 470, y, 240, 44));
    ucViews[u] = v;
    const av = a === actorCliente ? a1 : a === actorPropietario ? a2 : a3;
    const src = add(d, edgeView('UMLAssociationView', d._id, assocModel(a._id, ucs[u]._id)._id, av._id, v._id,
      [{ x: av.x + av.width, y: av.y + av.height / 2 }, { x: v.x, y: v.y + v.height / 2 }]));
    y += 58;
  });
  add(d, view('UMLTextView', d._id, null, 380, 615, 300, 30, { text: 'Figura 3.1. Actores del sistema' }));
}

// ============ D2: CASOS DE USO GENERAL ============
{
  const d = newDiagram('UMLUseCaseDiagram', 'Casos de Uso General');
  const sys = el('UMLClass', pkg._id, 'Plataforma Web SacaSabor'); pkg.ownedElements.push(sys);
  add(d, view('UMLUseCaseSubjectView', d._id, sys._id, 230, 40, 900, 640));
  const a1 = add(d, view('UMLActorView', d._id, actorCliente._id, 80, 90, 44, 70));
  const a2 = add(d, view('UMLActorView', d._id, actorPropietario._id, 80, 330, 44, 70));
  const a3 = add(d, view('UMLActorView', d._id, actorAdmin._id, 80, 530, 44, 70));

  const clienteUC = ['Iniciar Sesión', 'Registrarse', 'Cerrar Sesión', 'Buscar Chicharronerías',
    'Filtrar por Zona y Categoría', 'Ver Detalle de Chicharronería', 'Ver Menú y Productos',
    'Ver Ubicación en Mapa', 'Calificar con Estrellas', 'Escribir Comentario',
    'Eliminar su Comentario', 'Ver Páginas Institucionales', 'Enviar Mensaje de Contacto'];
  const propUC = ['Registrar su Chicharronería', 'Editar Datos de su Chicharronería', 'Gestionar Ubicación',
    'Gestionar Productos', 'Cambiar Disponibilidad', 'Ver Dashboard del Propietario', 'Editar su Perfil'];
  const adminUC = ['Gestionar Usuarios', 'Gestionar Chicharronerías', 'Eliminar Productos y Comentarios',
    'Gestionar Categorías', 'Ver Estadísticas', 'Consultar API REST'];

  function col(list, x, y0, actorView, actor) {
    let y = y0;
    list.forEach(n => {
      const v = add(d, view('UMLUseCaseView', d._id, ucs[n]._id, x, y, 250, 40));
      add(d, edgeView('UMLAssociationView', d._id, assocModel(actor._id, ucs[n]._id)._id, actorView._id, v._id,
        [{ x: actorView.x + actorView.width, y: actorView.y + actorView.height / 2 }, { x: v.x, y: v.y + v.height / 2 }]));
      y += 48;
    });
  }
  col(clienteUC, 300, 70, a1, actorCliente);
  col(propUC, 640, 320, a2, actorPropietario);
  col(adminUC, 640, 540, a3, actorAdmin);
}

// ============ D3: DIAGRAMA DE CLASES GENERAL ============
function buildClass(pkgId, name, attrs) {
  return el('UMLClass', pkgId, name, {
    attributes: attrs.map(a => el('UMLAttribute', name + '_cls', a, {}))
  });
}
const classDefs = [
  ['User', ['+ id: int', '+ name: string', '+ email: string', '+ password: string', '+ rol: enum', '+ telefono: string', '+ foto: string', '+ activo: boolean']],
  ['Chicharroneria', ['+ id: int', '+ propietario_id: int', '+ nombre: string', '+ descripcion: text', '+ direccion: string', '+ zona: string', '+ referencia: string', '+ telefono: string', '+ foto: string', '+ foto_portada: string', '+ latitud: string', '+ longitud: string', '+ destacado: boolean', '+ color: string', '+ activa: boolean']],
  ['Producto', ['+ id: int', '+ chicharroneria_id: int', '+ categoria_id: int', '+ nombre: string', '+ descripcion: text', '+ precio: decimal', '+ foto: string', '+ disponible: boolean']],
  ['Categoria', ['+ id: int', '+ nombre: string', '+ icono: string', '+ descripcion: string']],
  ['Calificacion', ['+ id: int', '+ usuario_id: int', '+ chicharroneria_id: int', '+ puntaje: tinyint']],
  ['Comentario', ['+ id: int', '+ usuario_id: int', '+ chicharroneria_id: int', '+ contenido: text']]
];
const classes = {};
{
  const pkgCls = el('UMLPackage', root._id, 'Modelos Eloquent');
  root.ownedElements.push(pkgCls);
  classDefs.forEach(([n, attrs]) => {
    const c = el('UMLClass', pkgCls._id, n, {
      attributes: attrs.map(a => {
        const at = el('UMLAttribute', pkgCls._id, a);
        const parts = a.replace(/^[+\-] /, '').split(':');
        at.name = parts[0];
        at.type = (parts[1] || '').trim();
        return at;
      })
    });
    pkgCls.ownedElements.push(c);
    classes[n] = c;
  });
}
{
  const d = newDiagram('UMLClassDiagram', 'Diagrama de Clases General');
  const pos = {
    User: [80, 60], Chicharroneria: [420, 60], Producto: [780, 60],
    Categoria: [780, 420], Calificacion: [80, 460], Comentario: [420, 460]
  };
  const views = {};
  Object.keys(pos).forEach(n => {
    const [x, y] = pos[n];
    const attrs = classes[n].attributes.map(a => ({ name: a.name, type: a.type, visibility: 'public' }));
    views[n] = add(d, view('UMLClassView', d._id, classes[n]._id, x, y, 280, 90 + attrs.length * 18, {
      suppressOperations: true
    }));
  });
  function assoc(a, b, la, lb, multip) {
    const va = views[a], vb = views[b];
    const p1 = { x: va.x + va.width / 2, y: va.y + va.height };
    const p2 = { x: vb.x + vb.width / 2, y: vb.y };
    add(d, edgeView('UMLAssociationView', d._id, assocModel(classes[a]._id, classes[b]._id)._id, va._id, vb._id, [p1, p2]));
  }
  assoc('User', 'Chicharroneria');
  assoc('Chicharroneria', 'Producto');
  assoc('Categoria', 'Producto');
  assoc('User', 'Calificacion');
  assoc('Chicharroneria', 'Calificacion');
  assoc('User', 'Comentario');
  assoc('Chicharroneria', 'Comentario');
}

// ============ D4: BASE DE DATOS (ENTIDADES) ============
{
  const d = newDiagram('UMLClassDiagram', 'Estructura General de la Base de Datos');
  const pos = {
    users: [60, 60, 'users (Laravel)', ['id', 'name', 'email', 'password', 'rol', 'telefono', 'foto', 'activo']],
    categorias: [420, 60, 'categorias', ['id', 'nombre', 'icono', 'descripcion']],
    chicharronerias: [760, 60, 'chicharronerias', ['id', 'propietario_id FK', 'nombre', 'descripcion', 'direccion', 'zona', 'referencia', 'telefono', 'foto', 'foto_portada', 'latitud', 'longitud', 'destacado', 'color', 'activa']],
    productos: [760, 400, 'productos', ['id', 'chicharroneria_id FK', 'categoria_id FK', 'nombre', 'descripcion', 'precio', 'foto', 'disponible']],
    calificaciones: [420, 400, 'calificaciones', ['id', 'usuario_id FK', 'chicharroneria_id FK', 'puntaje']],
    comentarios: [60, 400, 'comentarios', ['id', 'usuario_id FK', 'chicharroneria_id FK', 'contenido']]
  };
  const vs = {}, vsModel = {};
  Object.keys(pos).forEach(k => {
    const [x, y, name, fields] = pos[k];
    const c = el('UMLClass', pkg._id, name, { attributes: fields.map(f => { const a = el('UMLAttribute', pkg._id, f); a.name = f; return a; }) });
    pkg.ownedElements.push(c);
    vsModel[k] = c;
    vs[k] = add(d, view('UMLClassView', d._id, c._id, x, y, 260, 70 + fields.length * 18, { suppressOperations: true }));
  });
  function line(a, b) {
    const va = vs[a], vb = vs[b];
    add(d, edgeView('UMLAssociationView', d._id, assocModel(vsModel[a]._id, vsModel[b]._id)._id, va._id, vb._id,
      [{ x: va.x + va.width / 2, y: va.y + va.height / 2 }, { x: vb.x + vb.width / 2, y: vb.y + vb.height / 2 }]));
  }
  line('users', 'chicharronerias');
  line('chicharronerias', 'productos');
  line('categorias', 'productos');
  line('users', 'calificaciones');
  line('chicharronerias', 'calificaciones');
  line('users', 'comentarios');
  line('chicharronerias', 'comentarios');
}

// ============ D5: ARQUITECTURA ============
{
  const d = newDiagram('UMLClassDiagram', 'Arquitectura del Sistema');
  const boxes = [
    ['Capa de Presentación (Vista)', 60, 60, ['Blade · HTML5 · CSS3 · JavaScript', 'Leaflet.js + OpenStreetMap', 'Vite · Tailwind CSS']],
    ['Capa de Lógica (Controlador)', 420, 60, ['AuthController', 'ChicharroneriaController · ProductoController', 'PropietarioController · AdministradorController', 'OpinionController · ApiController']],
    ['Capa de Acceso a Datos (Modelo)', 780, 60, ['Eloquent ORM', 'User · Chicharroneria · Producto', 'Categoria · Calificacion · Comentario']],
    ['Base de Datos', 780, 360, ['MySQL / SQLite', 'Tablas Laravel + tablas del programador']],
    ['Capa de Servicios Externos', 60, 360, ['OpenStreetMap (mapas)', 'API REST JSON (/api)']]
  ];
  const made = [], madeModel = [];
  boxes.forEach(([name, x, y, lines]) => {
    const c = el('UMLClass', pkg._id, name, { attributes: lines.map(l => { const a = el('UMLAttribute', pkg._id, l); a.name = l; return a; }) });
    pkg.ownedElements.push(c);
    madeModel.push(c);
    made.push(add(d, view('UMLClassView', d._id, c._id, x, y, 300, 60 + lines.length * 18, { suppressOperations: true })));
  });
  function arrow(a, b) {
    add(d, edgeView('UMLAssociationView', d._id, assocModel(a.model.$ref, b.model.$ref)._id, a._id, b._id,
      [{ x: a.x + a.width, y: a.y + a.height / 2 }, { x: b.x, y: b.y + b.height / 2 }],
      { headEndArrow: 'openArrow' }));
  }
  arrow(made[0], made[1]);
  arrow(made[1], made[2]);
  arrow(made[2], made[3]);
  arrow(made[0], made[4]);
}

// ============ DIAGRAMAS POR SPRINT ============
function ucDiagram(name, list) {
  const d = newDiagram('UMLUseCaseDiagram', name);
  let y = 50;
  list.forEach(n => {
    add(d, view('UMLUseCaseView', d._id, ucs[n]._id, 340, y, 280, 44));
    y += 62;
  });
  return d;
}
function seqDiagram(name, lifelines, messages) {
  const d = newDiagram('UMLSequenceDiagram', name);
  const interaction = el('UMLInteraction', pkg._id, name + ' Interaction');
  pkg.ownedElements.push(interaction);
  const lineParts = [];
  lifelines.forEach((l, i) => {
    const lf = el('UMLLifeline', interaction._id, l, { represents: null });
    interaction.ownedElements.push(lf);
    const lvid = id(), ncId = id(), lpId = id();
    const labels = [
      { _type: 'LabelView', _id: id(), _parent: { $ref: ncId }, visible: false, font: 'Arial;13;0', parentStyle: true, height: 13 },
      { _type: 'LabelView', _id: id(), _parent: { $ref: ncId }, font: 'Arial;13;1', parentStyle: true, width: 161, height: 13, text: l },
      { _type: 'LabelView', _id: id(), _parent: { $ref: ncId }, visible: false, font: 'Arial;13;0', parentStyle: true, width: 280, height: 13 },
      { _type: 'LabelView', _id: id(), _parent: { $ref: ncId }, visible: false, font: 'Arial;13;0', parentStyle: true, height: 13, horizontalAlignment: 1 }
    ];
    const nc = { _type: 'UMLNameCompartmentView', _id: ncId, _parent: { $ref: lvid }, model: { $ref: lf._id }, font: 'Arial;13;0', parentStyle: true, top: 40, width: 171, height: 40, stereotypeLabel: { $ref: labels[0]._id }, nameLabel: { $ref: labels[1]._id }, namespaceLabel: { $ref: labels[2]._id }, propertyLabel: { $ref: labels[3]._id }, subViews: labels };
    const lp = { _type: 'UMLLinePartView', _id: lpId, _parent: { $ref: lvid }, model: { $ref: lf._id }, font: 'Arial;13;0', parentStyle: false, left: 70 + i * 230 + 85, top: 90, width: 1, height: 419 };
    const v = { _type: 'UMLSeqLifelineView', _id: lvid, _parent: { $ref: d._id }, model: { $ref: lf._id }, x: 70 + i * 230, y: 50, width: 170, height: 460, font: 'Arial;13;0', parentStyle: false, top: 40, nameCompartment: { $ref: ncId }, linePart: { $ref: lpId }, subViews: [nc, lp] };
    add(d, v);
    lineParts[i] = lpId;
  });
  messages.forEach((m, i) => {
    const [s, t, label] = m;
    const msg = el('UMLMessage', interaction._id, label, {
      source: { $ref: lifelines.indexOf(s) >= 0 ? interaction.ownedElements[lifelines.indexOf(s)]._id : interaction._id },
      target: { $ref: interaction.ownedElements[lifelines.indexOf(t)]._id }
    });
    interaction.ownedElements.push(msg);
    const si = lifelines.indexOf(s), ti = lifelines.indexOf(t);
    const y = 120 + i * 55;
    add(d, {
      _type: 'UMLSeqMessageView', _id: id(), _parent: { $ref: d._id }, model: { $ref: msg._id },
      tail: { $ref: lineParts[si] }, head: { $ref: lineParts[ti] },
      points: [{ x: 70 + si * 230 + 85, y: y + 15 }, { x: 70 + ti * 230 + 85, y: y + 15 }],
      font: 'Arial;13;0', parentStyle: false
    });
  });
  return d;
}
function actDiagram(name, nodes, flows) {
  const d = newDiagram('UMLActivityDiagram', name);
  const activity = el('UMLActivity', pkg._id, name + ' Activity');
  pkg.ownedElements.push(activity);
  const nv = {};
  nodes.forEach(([key, label, x, y, kind]) => {
    let type = 'UMLAction', w = 220, h = 56;
    if (kind === 'start') { type = 'UMLControlNode'; w = 40; h = 40; }
    if (kind === 'end') { type = 'UMLFinalState'; w = 40; h = 40; }
    if (kind === 'decision') { type = 'UMLControlNode'; w = 60; h = 60; }
    let model;
    if (type === 'UMLControlNode') model = kind === 'decision'
      ? el('UMLDecisionNode', activity._id, label)
      : el('UMLInitialNode', activity._id, label);
    else if (type === 'UMLFinalState') model = el('UMLFinalState', activity._id, label);
    else model = el('UMLAction', activity._id, label);
    activity.ownedElements.push(model);
    const vt = type === 'UMLControlNode' ? 'UMLControlNodeView'
      : type === 'UMLFinalState' ? 'UMLFinalStateView' : 'UMLActionView';
    nv[key] = add(d, view(vt, d._id, model._id, x, y, w, h));
  });
  flows.forEach(([s, t, label]) => {
    const cf = el('UMLControlFlow', activity._id, label || '', {
      source: { $ref: activity.ownedElements[0]._id }, target: { $ref: activity.ownedElements[0]._id }
    });
    activity.ownedElements.push(cf);
    const sv = nv[s], tv = nv[t];
    add(d, edgeView('UMLControlFlowView', d._id, cf._id, sv._id, tv._id, [
      { x: sv.x + sv.width / 2, y: sv.y + sv.height / 2 },
      { x: tv.x + tv.width / 2, y: tv.y + tv.height / 2 }
    ], { headEndArrow: 'solidArrow' }));
  });
  return d;
}

// --- Sprint 1 ---
ucDiagram('Sprint 1 - Casos de Uso: Autenticación', [
  'Registrarse', 'Iniciar Sesión', 'Cerrar Sesión', 'Ver Dashboard del Propietario', 'Gestionar Usuarios']);
seqDiagram('Sprint 1 - Secuencia: Iniciar Sesión',
  ['Usuario', 'Navegador', 'AuthController', 'Base de Datos'],
  [['Usuario', 'Navegador', 'Ingresa nombre y contraseña'],
   ['Navegador', 'AuthController', 'POST /iniciar-sesion'],
   ['AuthController', 'Base de Datos', 'Valida credenciales (hash)'],
   ['Base de Datos', 'AuthController', 'Usuario encontrado'],
   ['AuthController', 'Navegador', 'Redirige según rol']]);
actDiagram('Sprint 1 - Actividades: Iniciar Sesión',
  [['ini', '', 60, 40, 'start'], ['form', 'Mostrar formulario de acceso', 30, 120, 'action'],
   ['val', 'Validar credenciales', 30, 210, 'action'], ['dec', '', 45, 300, 'decision'],
   ['dash', 'Redirigir al dashboard según rol', 30, 390, 'action'], ['err', 'Mostrar mensaje de error', 300, 300, 'action'],
   ['fin', '', 130, 490, 'end']],
  [['ini', 'form'], ['form', 'val'], ['val', 'dec'], ['dec', 'dash'], ['dec', 'err'], ['dash', 'fin']]);

// --- Sprint 2 ---
ucDiagram('Sprint 2 - Casos de Uso: Consulta Pública y Opiniones', [
  'Buscar Chicharronerías', 'Filtrar por Zona y Categoría', 'Ver Detalle de Chicharronería',
  'Ver Menú y Productos', 'Ver Ubicación en Mapa', 'Calificar con Estrellas',
  'Escribir Comentario', 'Eliminar su Comentario']);
seqDiagram('Sprint 2 - Secuencia: Calificar y Comentar',
  ['Cliente', 'Navegador', 'OpinionController', 'Base de Datos'],
  [['Cliente', 'Navegador', 'Selecciona 1 a 5 estrellas y escribe opinión'],
   ['Navegador', 'OpinionController', 'POST /chicharronerias/{id}/opiniones'],
   ['OpinionController', 'Base de Datos', 'updateOrCreate calificación'],
   ['OpinionController', 'Base de Datos', 'create comentario (si existe texto)'],
   ['Base de Datos', 'OpinionController', 'Registro guardado'],
   ['OpinionController', 'Navegador', 'Respuesta: Gracias por tu opinión']]);
actDiagram('Sprint 2 - Actividades: Consulta de Chicharronerías',
  [['ini', '', 60, 30, 'start'], ['list', 'Listar chicharronerías activas', 30, 100, 'action'],
   ['filt', 'Aplicar filtros (nombre, zona, categoría)', 30, 180, 'action'], ['dec', '', 45, 265, 'decision'],
   ['show', 'Mostrar detalle: menú, información y opiniones', 30, 350, 'action'],
   ['map', 'Mostrar ubicación en mapa Leaflet', 320, 350, 'action'],
   ['op', 'Registrar calificación y comentario', 30, 430, 'action'],
   ['fin', '', 130, 520, 'end']],
  [['ini', 'list'], ['list', 'filt'], ['filt', 'dec'], ['dec', 'show'], ['show', 'map'], ['map', 'op'], ['op', 'fin']]);

// --- Sprint 3 ---
ucDiagram('Sprint 3 - Casos de Uso: Panel del Propietario', [
  'Registrar su Chicharronería', 'Editar Datos de su Chicharronería', 'Gestionar Ubicación',
  'Gestionar Productos', 'Cambiar Disponibilidad', 'Editar su Perfil']);
seqDiagram('Sprint 3 - Secuencia: Gestión de Productos',
  ['Propietario', 'Navegador', 'ProductoController', 'Base de Datos'],
  [['Propietario', 'Navegador', 'Completa formulario de producto'],
   ['Navegador', 'ProductoController', 'POST /propietario/productos'],
   ['ProductoController', 'ProductoController', 'Valida datos y verifica rol propietario'],
   ['ProductoController', 'Base de Datos', 'create producto'],
   ['Base de Datos', 'ProductoController', 'Producto registrado'],
   ['ProductoController', 'Navegador', 'Redirige al listado con mensaje de éxito']]);
actDiagram('Sprint 3 - Actividades: Gestión de Disponibilidad',
  [['ini', '', 60, 30, 'start'], ['list', 'Listar productos de su chicharronería', 30, 100, 'action'],
   ['tog', 'Pulsar botón de disponibilidad', 30, 180, 'action'],
   ['upd', 'Cambiar disponible: verdadero / falso', 30, 260, 'action'],
   ['save', 'Guardar cambio en la base de datos', 30, 340, 'action'],
   ['fin', '', 130, 430, 'end']],
  [['ini', 'list'], ['list', 'tog'], ['tog', 'upd'], ['upd', 'save'], ['save', 'fin']]);

// --- Sprint 4 ---
ucDiagram('Sprint 4 - Casos de Uso: Panel del Administrador y API',
  ['Gestionar Usuarios', 'Gestionar Chicharronerías', 'Eliminar Productos y Comentarios',
   'Gestionar Categorías', 'Ver Estadísticas', 'Consultar API REST']);
seqDiagram('Sprint 4 - Secuencia: Gestión de Usuarios (Administrador)',
  ['Administrador', 'Navegador', 'AdministradorController', 'Base de Datos'],
  [['Administrador', 'Navegador', 'Selecciona usuario y nuevo rol'],
   ['Navegador', 'AdministradorController', 'PUT /admin/usuarios/{id}'],
   ['AdministradorController', 'AdministradorController', 'Valida rol administrador (RoleMiddleware)'],
   ['AdministradorController', 'Base de Datos', 'update usuario'],
   ['Base de Datos', 'AdministradorController', 'Cambios guardados'],
   ['AdministradorController', 'Navegador', 'Redirige al listado actualizado']]);
actDiagram('Sprint 4 - Actividades: Consulta a la API REST',
  [['ini', '', 60, 30, 'start'], ['req', 'GET /api/chicharronerias', 30, 100, 'action'],
   ['ctrl', 'ApiController consulta modelos Eloquent', 30, 180, 'action'],
   ['json', 'Construye respuesta JSON (total, datos)', 30, 260, 'action'],
   ['cod', '', 45, 345, 'decision'], ['ok', 'Devuelve código 200', 30, 430, 'action'],
   ['err404', 'Devuelve código 404', 320, 430, 'action'], ['fin', '', 130, 520, 'end']],
  [['ini', 'req'], ['req', 'ctrl'], ['ctrl', 'json'], ['json', 'cod'], ['cod', 'ok'], ['cod', 'err404'], ['ok', 'fin']]);

const outFile = process.argv[2];
function normalizePoints(o) {
  if (Array.isArray(o.points)) {
    o.points = o.points.map(p => p.x + ':' + p.y).join(';');
  }
  for (const k in o) {
    if (o[k] && typeof o[k] === 'object') normalizePoints(o[k]);
  }
  return o;
}
normalizePoints(project);
fs.writeFileSync(outFile, JSON.stringify(project, null, '\t'), 'utf8');
console.log('OK: ' + outFile + ' | diagramas: ' + root.ownedElements.filter(e => /Diagram$/.test(e._type)).length);
