const center = { x: 325, y: 175 };
const serv_dist = 250;
const pointer_dist = 172;
const pointer_time = 2;
const icon_size = 42;
const circle_radius = 38;
const text_top_margin = 18;
const tspan_delta = 16;

//name is used as the title for the bubble
//icon is the id of the corresponding svg symbol
const services_data = [
  { name: "Industries", icon: "industries" },
  { name: "Validation\n(C&Q and CSV)", icon: "validation" },
  { name: "Engineering", icon: "engineering" },
  { name: "Project\nManagement", icon: "management" },
  { name: "Manufacturing\nIT", icon: "manufacturing" },
  { name: "Technical\nServices", icon: "technical" },
  { name: "Process\nAutomation", icon: "process" }
];

const services = document.getElementById("service-collection");
const nav_container = document.getElementById("circle-nav-services");
const symbol_copy = document.getElementById("circle-nav-copy");
const use_copy = document.querySelector("use.nav-copy");

//Keeps code DRY avoiding namespace for element creation
function createSVGElement(el){
  return document.createElementNS("http://www.w3.org/2000/svg", el)
}

//Quick setup for multiple attributes
function setAttributes(el, options) {
   Object.keys(options).forEach(function(attr) {
     el.setAttribute(attr, options[attr]);
   })
}

//Service bubbles are created dynamically
function addService(serv,index) {
  let group = createSVGElement("g");
  group.setAttribute("class", "service serv-"+index);

  /* This group is needed to apply animations in
    the icon and its background at the same time */
  let icon_group = createSVGElement("g");
  icon_group.setAttribute("class", "icon-wrapper");

  let circle = createSVGElement("circle");
  setAttributes(circle,{
    r: circle_radius,
    cx:center.x,
    cy:center.y
  });
  let circle_shadow = circle.cloneNode();
  setAttributes(circle,{
    class:'shadow'
  });
  icon_group.appendChild(circle_shadow);
  icon_group.appendChild(circle);

  let symbol = createSVGElement("use");
  setAttributes(symbol, {
    'x': center.x - (icon_size/2),
    'y': center.y - (icon_size/2),
    'width':icon_size,
    'height':icon_size,
  });
  symbol.setAttributeNS("http://www.w3.org/1999/xlink","xlink:href","#"+serv.icon);
  icon_group.appendChild(symbol);

  group.appendChild(icon_group);

  let text = createSVGElement("text");
  setAttributes(text,{
    x: center.x,
    y: center.y + circle_radius + text_top_margin
  });
  
  let tspan = createSVGElement("tspan");
  if (serv.name.indexOf('\n') >= 0) {
    
    let tspan2 = tspan.cloneNode();
    let name = serv.name.split('\n');
    jQuery(tspan).text(name[0]);
    jQuery(tspan2).text(name[1]);
    
    setAttributes(tspan2, {
      x: center.x,
      dy: tspan_delta
    });
    
    text.appendChild(tspan);
    text.appendChild(tspan2);
  }
  else {
    jQuery(tspan).text(serv.name);
    text.appendChild(tspan);
  }

  group.appendChild(text);
  services.appendChild(group);
  
  let service_bubble = jQuery(".serv-"+index);
  
  //Uses tween to look for right position
  twn_pivot_path.seek(index);
  TweenLite.set(service_bubble,{
    x: pivot_path.x,
    y: pivot_path.y,
    transformOrigin:"center center"
  });
  
  service_bubble.click(serviceClick);
}

//Creates pointer
function createPointer() {
  let service_pointer = createSVGElement("circle");
  
  setAttributes(service_pointer,{
    cx: center.x - pointer_dist,
    cy: center.y,
    r: 12,
    class: "pointer"
  });
  
  nav_container.appendChild(service_pointer);
  
  service_pointer = document.querySelector("svg .pointer");
  
  let pointer_circle = [
    {x:0,y:0},
    {x:pointer_dist,y:pointer_dist},
    {x:pointer_dist*2,y:0},
    {x:pointer_dist,y:-pointer_dist},
    {x:0,y:0}
  ];
  
  twn_pointer_path.to(service_pointer, pointer_time, {
    bezier:{
      values: pointer_circle,
      curviness: 1.5},
    ease: Power0.easeNone,
    transformOrigin: "center center"
  });
  
}

//Defines behavior for service bubbles
function serviceClick(ev){
  
  //There's always an active service
  jQuery(".service.active").removeClass("active");
  
  let current = jQuery(ev.currentTarget);
  current.addClass("active");
  
  //There's a "serv-*" class for each bubble
  let current_class = current.attr("class").split(" ")[1];
  let class_index = current_class.split('-')[1];
  
  //Hides current text of the main bubble
  jQuery(use_copy).addClass("changing");
  
  //Sets pointer to the right position
  twn_pointer_path.tweenTo(class_index*(pointer_time/(2*6)));
  
  //After it's completely hidden, the text changes and becomes visible
  setTimeout(()=> {
    let viewBoxY = 300*class_index;
    symbol_copy.setAttribute("viewBox","0 "+viewBoxY+" 300 300");
    jQuery(use_copy).removeClass("changing")
  },250)
}

//Array describes points for a whole circle in order to get
//the right curve
let half_circle = [
  {x:-serv_dist, y:0},
  {x:0 , y:serv_dist},
  {x:serv_dist, y:0},
  {x:0 , y:-serv_dist},
  {x:-serv_dist, y:0}
];

//A simple object is used in the tween to retrieve its values
var pivot_path = {x: half_circle[0].x , y: half_circle[0].y};

//The object is animated with a duration based on how many bubbles
//should be placed
var twn_pivot_path = TweenMax.to(pivot_path, 12,{
  bezier: {
    values:half_circle,
    curviness: 1.5
  },
  ease: Linear.easeNone
});

services_data.reduce((count, serv)=> {
  addService(serv,count);
  return ++count;
},0);

//The variable is modified inside the function
//but its also used later to toggle its class
var twn_pointer_path = new TimelineMax({paused: true});
createPointer();

//Adding it immediately triggers a bug for the transform
setTimeout(()=> jQuery("#service-collection .serv-0").addClass("active"),200);