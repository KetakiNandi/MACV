//const noteRoutes = require('./note_routes');
//const noteRoutesForReachOut = require('./Exec_Insights');
const noteRoutesForMACV = require('./SalesRep_Insights');
//const noteRoutesForReachOutComment = require('./Tasks');
module.exports = function(app, db) {
  //console.log(db);
  //noteRoutes(app, db);
  //noteRoutesForReachOut(app,db);
  noteRoutesForMACV(app,db);
  //noteRoutesForReachOutComment(app,db);
  // Other route groups could go here, in the future
};
