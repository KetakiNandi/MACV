//const noteRoutes = require('./note_routes');
const noteRoutesForLYK = require('./RealTime_User');
//const noteRoutesForMACV = require('./SalesRep_Insights');
//const noteRoutesForReachOutComment = require('./Tasks');
module.exports = function(io, db) {
  //console.log(db);
  //noteRoutes(app, db);
  noteRoutesForLYK(io,db);
  //noteRoutesForMACV(app,db);
  //noteRoutesForReachOutComment(app,db);
  // Other route groups could go here, in the future
};
