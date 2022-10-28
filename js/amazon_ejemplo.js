// The following data should be run in the console while viewing the page https://read.amazon.com/
// It will export a CSV file called "download" which can (and should) be renamed with a .csv extension


function getAmazonCsv() {
  var db = openDatabase('K4W', '3', 'thedatabase', 1024 * 1024);
  // Set header for CSV export line - change this if you change the fields used
  var csvData = "ASIN,Title,Authors,PurchaseDate\n";

  db.transaction(function(tx) {
    tx.executeSql('SELECT * FROM bookdata;', [], function(tx, results) {
      var len = results.rows.length;

      for (i = 1; i < len; i++) {
        // Get the data
        var asin = results.rows.item(i).asin;
        var title = results.rows.item(i).title;
        var authors = JSON.parse(results.rows.item(i).authors);
        var purchaseDate = new Date(results.rows.item(i).purchaseDate).toLocaleDateString();

        // Remove double quotes from titles to not interfere with CSV double-quotes 
        title = title.replace(/"/g, '');

        
        // Concatenate the authors list - uncomment the next line to get all authors separated by ";"
        // var authorList = authors.join(';');
        // OR Take only first author - comment the next line if you uncommented the previous one
        var authorList = authors[0];

        // Write out the CSV line
        csvData += '"' + asin + '","' + title + '","' + authorList + '","' + purchaseDate + '"\n'
      }

      // "Export" the data
      window.location = 'data:text/csv;charset=utf8,' + encodeURIComponent(csvData);

      console.log("Sample Row:");
      console.log(results.rows.item(1));
    });
  });
};

