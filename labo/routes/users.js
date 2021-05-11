var express = require('express');
var router = express.Router();

/* GET user login*/
router.get('/login', (req, res, next) => {
    res.render('userLogin', { title: 'User Login' });
});

/* GET user account. */
router.get('/', (req, res, next) => {
  res.render('userAccount', { title: 'User Account' });
});

module.exports = router;
