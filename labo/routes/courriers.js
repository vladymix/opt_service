var express = require('express');
var router = express.Router();

/* GET courrier login*/
router.get('/login', (req, res, next) => {
    res.render('courrierLogin', { title: 'Courrier Login' });
});

/* GET courrier account. */
router.get('/', (req, res, next) => {
  res.render('courrierAccount', { title: 'Courrier Account' });
});

module.exports = router;
