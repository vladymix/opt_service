//Carga de librerias a utilizar
const Express = require('express');
const BodyParser=require('body-parser');
const passport = require('passport');
const cookieParser=require('cookie-parser');
const session=require('express-session');
const PassportLocal=require('passport-local').Strategy;

const app=Express();

//CONFIGURACION DE LAS LIBRERIAS
//Para que express lea información del formulario
app.use(Express.urlencoded({extended:true}));
//Para configurar la codificación en el formulario
app.use(cookieParser('nuestroSecreto'));
app.use(session({
    secret: 'nuestroSecreto',
    resave:true,    //En cada sesion aunque esta no haya sido modificada la volveremos a guardar
    saveUninitialized:true 
}
))
//para configurar Passport
app.use(passport.initialize());
app.use(passport.session());

passport.use(new PassportLocal(function(username, password, done){
    if (username==="user" && password==="1234"){
        return done(null, {id: 1, name: "User1"});
    }
    else {if (username==="courrier" && password==="9876"){
    return done(null, {id: 2, name: "Courrier1"});}
    }
    done(null, false);
}));
//serialización
passport.serializeUser(function(user, done){
    done(null,user.id);
})
passport.deserializeUser(function(id, done){
    done(null, {id:1, name:"User1"},{id:2, name:"Courrier1"});
})




//Se establece Motor de Vista ejs
app.set('view engine', 'ejs');


//Direccionamiento de páginas
app.get('/', function(req,res){
    res.send('Hola Mundo');
});
 app.get("/userLogin", (req,res)=> {
     res.render("userLogin");
 });
 app.get('/courrierLogin', (req,res)=> {
    res.render("courrierLogin");
});
 

/* app.post("/userLogin",(req,res)=>{
//Recibir formulario usr
}); */

app.post("/userLogin",passport.authenticate('local',{
    successRedirect: "/user",
    failureRedirect:"/userLogin"
    }));
app.post("courrierLogin",passport.authenticate('local',{
    successRedirect: "/courrier",
    failureRedirect:"/courrierLogin"
}));

/*  app.post("/courrierLogin",(req,res)=>{
//Recibir formulario de Courrier
});  */

app.get("/user", (req,res,next)=>{
    if(req.isAuthenticated())return next();
    else res.redirect("/userLogin");
},
    (req,res)=>{
    res.redirect("userLogin")
})

app.get("/courrier", (req,res,next)=>{
    if(req.isAuthenticated())return next();
    else res.redirect("/courrierLogin");
},
    (req,res)=>{
    res.redirect("courrierLogin")
});
/* 
app.get("/courrier", (req,res)=>{
    res.render("courrier")
}); */

//Se pone el server a escuchar en el puerto 3000
app.listen(3000,()=>{
    console.log('Server on port 3000');
});