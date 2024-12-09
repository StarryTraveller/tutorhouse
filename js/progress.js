

function ichart(day, count,iid) {
    var data = {
      chart: {
        type: "bar",
      },
      series: [
        {
          name: "Appointments",
          data: count,
        },
      ],
      xaxis: {
        categories: day,
      },
    };
  
    var chart = new ApexCharts(document.querySelector("#" + iid), data);
  
    chart.render();
  }
  
  
  
  
  function getichart(PHP, iid) {
    $.ajax({
      url: PHP,
      type: "get",
      contentType: false,
      processData: false,
      cache: false,
      success: function (dataResult) {
        console.log(dataResult)
        // let chartData = JSON.parse(dataResult);
        // let arrdoctor = [];
        // let arrcount = [];
        // chartData.forEach((element) => {
        //   arrdoctor.push(element[0]);
        //   arrcount.push(element[1]);
        // });
        // ichart(arrdoctor, arrcount, iid);
      },
      error: function (xhr, ajaxOptions, thrownError) {
        showerror(thrownError);
      },
    });
  }
  