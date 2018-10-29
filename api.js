/**
 * Author: Nuri Melih Sensoy
 * 
 * DU Announcements API
 */
const express = require('express')
const app = express()
var fs = require('fs')
var Xray = require('x-ray')

var x = Xray({
  filters: {
    trim: function (value) {
      return typeof value === 'string' ? value.trim() : value
    },
    reverse: function (value) {
      return typeof value === 'string' ? value.split('').reverse().join('') : value
    },
    slice: function (value, start , end) {
      return typeof value === 'string' ? value.slice(start, end) : value
    },
    cleanDate: function (value) {
        return typeof value === 'string' ? value.replace(/\r|\t|\n/g, "").trim() : value
    },
    whiteSpaces: function (value) {
        return typeof value === 'string' ? value.replace(/ +/g, ' ').trim() : value
    },
    isNewAnon: function (value) {
        return typeof value === 'string' ? value.replace("Yeni", true).trim() : value
    }
  }
});

var obj;
fs.readFile('divisions.json', 'utf8', function (err, data) {
  if (err) throw err;
  obj = JSON.parse(data);
});

app.get('/', (req, res) => {
  res.sendFile(__dirname + '/doc.html');
})

app.get('/divisions/', (req, res) => {
    res.json(obj);
})

app.get('/division/:id', (req, res) => {
    divisionPage = obj[parseInt(req.params.id)];

    res.json(divisionPage);
})

app.get('/division/:id/announce', (req, res) => {
    categoryLink = obj[parseInt(req.params.id)]['link'];

    x(categoryLink, 'ul.news-items li', [{  
    title: '.news-content h4 | cleanDate | whiteSpaces',
    date: 'p.news-date,.blog-date | cleanDate | whiteSpaces',
    image: '.news-image .news-cover img@src',
    desc: '.news-content | cleanDate | whiteSpaces',
    link: '.news-content h4 a@href',
    is_new: 'span.btn-yeni | isNewAnon'
    }])(function(err, result){
        //console.log(result)
        res.json(result);
    });
})

app.listen(3000)