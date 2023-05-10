var chartOneOptions = {
    chart: {
        type: 'donut',
        width: 100
    },
    colors: ['#dea41f', '#dea41f', '#dea41f', '#dea41f'],
    dataLabels: {
      enabled: false
    },
    legend: {
        position: 'bottom',
        horizontalAlign: 'center',
        fontSize: '12px',
        markers: {
          width: 10,
          height: 10,
        },
        itemMargin: {
          horizontal: 0,
          vertical: 8
        }
    },
    plotOptions: {
      pie: {
        donut: {
          size: '80%',
          background: 'transparent',
          labels: {
            show: true,
            name: {
              show: true,
              fontSize: '26px',
              fontFamily: 'Nunito, sans-serif',
              color: undefined,
              offsetY: -10
            },
            value: {
              show: true,
              fontSize: '22px',
              fontFamily: 'Nunito, sans-serif',
              color: '#bfc9d4',
              offsetY: 16,
              formatter: function (val) {
                return val
              }
            },
            total: {
              show: true,
              showAlways: true,
              label: '453',
              color: '#000000',
              width: '40px',
              height: '40px',
              formatter: function (w) {
                return w.globals.seriesTotals.reduce( function(a, b) {
                  return a + b
                }, 0)
              }
            }
          }
        }
      }
    },
    stroke: {
      show: true,
      width:10
    },
    series: [985],
    responsive: [{
        breakpoint: 1599,
        options: {
            chart: {
                width: '200px',
                height: '200px'
            },
            legend: {
                position: 'bottom'
            }
        },

        breakpoint: 1439,
        options: {
            chart: {
                width: '120%',
                height: '220px'
            },
            legend: {
                position: 'bottom'
            },
            plotOptions: {
              pie: {
                donut: {
                  size: '70%',
                }
              }
            }
        },
    }]
}
var chartOne = new ApexCharts(
    document.querySelector("#chartOne"),
    chartOneOptions
);

chartOne.render();
/*
----------------------------------------------------------------------------
*/







var charttwoOptions = {
    chart: {
        type: 'donut',
        width: 100
    },
    colors: ['#4f6cfd', '#4f6cfd', '#4f6cfd', '#4f6cfd'],
    dataLabels: {
      enabled: false
    },
    legend: {
        position: 'bottom',
        horizontalAlign: 'center',
        fontSize: '12px',
        markers: {
          width: 10,
          height: 10,
        },
        itemMargin: {
          horizontal: 0,
          vertical: 8
        }
    },
    plotOptions: {
      pie: {
        donut: {
          size: '80%',
          background: 'transparent',
          labels: {
            show: true,
            name: {
              show: true,
              fontSize: '26px',
              fontFamily: 'Nunito, sans-serif',
              color: undefined,
              offsetY: -10
            },
            value: {
              show: true,
              fontSize: '22px',
              fontFamily: 'Nunito, sans-serif',
              color: '#bfc9d4',
              offsetY: 16,
              formatter: function (val) {
                return val
              }
            },
            total: {
              show: true,
              showAlways: true,
              label: '453',
              color: '#000000',
              width: '40px',
              height: '40px',
              formatter: function (w) {
                return w.globals.seriesTotals.reduce( function(a, b) {
                  return a + b
                }, 0)
              }
            }
          }
        }
      }
    },
    stroke: {
      show: true,
      width:10
    },
    series: [985],
    responsive: [{
        breakpoint: 1599,
        options: {
            chart: {
                width: '200px',
                height: '200px'
            },
            legend: {
                position: 'bottom'
            }
        },

        breakpoint: 1439,
        options: {
            chart: {
                width: '120%',
                height: '220px'
            },
            legend: {
                position: 'bottom'
            },
            plotOptions: {
              pie: {
                donut: {
                  size: '70%',
                }
              }
            }
        },
    }]
}
var charttwo = new ApexCharts(
    document.querySelector("#charttwo"),
    charttwoOptions
);

charttwo.render();
/*
----------------------------------------------------------------------------
*/





var chartthreeOptions = {
    chart: {
        type: 'donut',
        width: 100
    },
    colors: ['#8ac344', '#4f6cfd', '#4f6cfd', '#4f6cfd'],
    dataLabels: {
      enabled: false
    },
    legend: {
        position: 'bottom',
        horizontalAlign: 'center',
        fontSize: '12px',
        markers: {
          width: 10,
          height: 10,
        },
        itemMargin: {
          horizontal: 0,
          vertical: 8
        }
    },
    plotOptions: {
      pie: {
        donut: {
          size: '80%',
          background: 'transparent',
          labels: {
            show: true,
            name: {
              show: true,
              fontSize: '26px',
              fontFamily: 'Nunito, sans-serif',
              color: undefined,
              offsetY: -10
            },
            value: {
              show: true,
              fontSize: '22px',
              fontFamily: 'Nunito, sans-serif',
              color: '#bfc9d4',
              offsetY: 16,
              formatter: function (val) {
                return val
              }
            },
            total: {
              show: true,
              showAlways: true,
              label: '453',
              color: '#000000',
              width: '40px',
              height: '40px',
              formatter: function (w) {
                return w.globals.seriesTotals.reduce( function(a, b) {
                  return a + b
                }, 0)
              }
            }
          }
        }
      }
    },
    stroke: {
      show: true,
      width:10
    },
    series: [985],
    responsive: [{
        breakpoint: 1599,
        options: {
            chart: {
                width: '200px',
                height: '200px'
            },
            legend: {
                position: 'bottom'
            }
        },

        breakpoint: 1439,
        options: {
            chart: {
                width: '120%',
                height: '220px'
            },
            legend: {
                position: 'bottom'
            },
            plotOptions: {
              pie: {
                donut: {
                  size: '70%',
                }
              }
            }
        },
    }]
}
var chartthree = new ApexCharts(
    document.querySelector("#chartthree"),
    chartthreeOptions
);

chartthree.render();
/*
----------------------------------------------------------------------------
*/



var chartfourOptions = {
    chart: {
        type: 'donut',
        width: 100
    },
    colors: ['#f77925', '#4f6cfd', '#4f6cfd', '#4f6cfd'],
    dataLabels: {
      enabled: false
    },
    legend: {
        position: 'bottom',
        horizontalAlign: 'center',
        fontSize: '12px',
        markers: {
          width: 10,
          height: 10,
        },
        itemMargin: {
          horizontal: 0,
          vertical: 8
        }
    },
    plotOptions: {
      pie: {
        donut: {
          size: '80%',
          background: 'transparent',
          labels: {
            show: true,
            name: {
              show: true,
              fontSize: '26px',
              fontFamily: 'Nunito, sans-serif',
              color: undefined,
              offsetY: -10
            },
            value: {
              show: true,
              fontSize: '22px',
              fontFamily: 'Nunito, sans-serif',
              color: '#bfc9d4',
              offsetY: 16,
              formatter: function (val) {
                return val
              }
            },
            total: {
              show: true,
              showAlways: true,
              label: '453',
              color: '#000000',
              width: '40px',
              height: '40px',
              formatter: function (w) {
                return w.globals.seriesTotals.reduce( function(a, b) {
                  return a + b
                }, 0)
              }
            }
          }
        }
      }
    },
    stroke: {
      show: true,
      width:10
    },
    series: [985],
    responsive: [{
        breakpoint: 1599,
        options: {
            chart: {
                width: '200px',
                height: '200px'
            },
            legend: {
                position: 'bottom'
            }
        },

        breakpoint: 1439,
        options: {
            chart: {
                width: '120%',
                height: '220px'
            },
            legend: {
                position: 'bottom'
            },
            plotOptions: {
              pie: {
                donut: {
                  size: '70%',
                }
              }
            }
        },
    }]
}
var chartfour = new ApexCharts(
    document.querySelector("#chartfour"),
    chartfourOptions
);

chartfour.render();
/*
----------------------------------------------------------------------------
*/




var chartfiveOptions = {
    chart: {
        type: 'donut',
        width: 100
    },
    colors: ['#4f6cfd', '#4f6cfd', '#4f6cfd', '#4f6cfd'],
    dataLabels: {
      enabled: false
    },
    legend: {
        position: 'bottom',
        horizontalAlign: 'center',
        fontSize: '12px',
        markers: {
          width: 10,
          height: 10,
        },
        itemMargin: {
          horizontal: 0,
          vertical: 8
        }
    },
    plotOptions: {
      pie: {
        donut: {
          size: '80%',
          background: 'transparent',
          labels: {
            show: true,
            name: {
              show: true,
              fontSize: '26px',
              fontFamily: 'Nunito, sans-serif',
              color: undefined,
              offsetY: -10
            },
            value: {
              show: true,
              fontSize: '22px',
              fontFamily: 'Nunito, sans-serif',
              color: '#bfc9d4',
              offsetY: 16,
              formatter: function (val) {
                return val
              }
            },
            total: {
              show: true,
              showAlways: true,
              label: '453',
              color: '#000000',
              width: '40px',
              height: '40px',
              formatter: function (w) {
                return w.globals.seriesTotals.reduce( function(a, b) {
                  return a + b
                }, 0)
              }
            }
          }
        }
      }
    },
    stroke: {
      show: true,
      width:10
    },
    series: [985],
    responsive: [{
        breakpoint: 1599,
        options: {
            chart: {
                width: '200px',
                height: '200px'
            },
            legend: {
                position: 'bottom'
            }
        },

        breakpoint: 1439,
        options: {
            chart: {
                width: '120%',
                height: '220px'
            },
            legend: {
                position: 'bottom'
            },
            plotOptions: {
              pie: {
                donut: {
                  size: '70%',
                }
              }
            }
        },
    }]
}
var chartfive = new ApexCharts(
    document.querySelector("#chartfive"),
    chartfiveOptions
);

chartfive.render();
/*
----------------------------------------------------------------------------
*/


var chartsixOptions = {
    chart: {
        type: 'donut',
        width: 100
    },
    colors: ['#49b0a4', '#4f6cfd', '#4f6cfd', '#4f6cfd'],
    dataLabels: {
      enabled: false
    },
    legend: {
        position: 'bottom',
        horizontalAlign: 'center',
        fontSize: '12px',
        markers: {
          width: 10,
          height: 10,
        },
        itemMargin: {
          horizontal: 0,
          vertical: 8
        }
    },
    plotOptions: {
      pie: {
        donut: {
          size: '80%',
          background: 'transparent',
          labels: {
            show: true,
            name: {
              show: true,
              fontSize: '26px',
              fontFamily: 'Nunito, sans-serif',
              color: undefined,
              offsetY: -10
            },
            value: {
              show: true,
              fontSize: '22px',
              fontFamily: 'Nunito, sans-serif',
              color: '#bfc9d4',
              offsetY: 16,
              formatter: function (val) {
                return val
              }
            },
            total: {
              show: true,
              showAlways: true,
              label: '453',
              color: '#000000',
              width: '40px',
              height: '40px',
              formatter: function (w) {
                return w.globals.seriesTotals.reduce( function(a, b) {
                  return a + b
                }, 0)
              }
            }
          }
        }
      }
    },
    stroke: {
      show: true,
      width:10
    },
    series: [985],
    responsive: [{
        breakpoint: 1599,
        options: {
            chart: {
                width: '200px',
                height: '200px'
            },
            legend: {
                position: 'bottom'
            }
        },

        breakpoint: 1439,
        options: {
            chart: {
                width: '120%',
                height: '220px'
            },
            legend: {
                position: 'bottom'
            },
            plotOptions: {
              pie: {
                donut: {
                  size: '70%',
                }
              }
            }
        },
    }]
}
var chartsix = new ApexCharts(
    document.querySelector("#chartsix"),
    chartsixOptions
);

chartsix.render();
/*
----------------------------------------------------------------------------
*/



var chartseavenOptions = {
    chart: {
        type: 'donut',
        width: 100
    },
    colors: ['#e2525d', '#4f6cfd', '#4f6cfd', '#4f6cfd'],
    dataLabels: {
      enabled: false
    },
    legend: {
        position: 'bottom',
        horizontalAlign: 'center',
        fontSize: '12px',
        markers: {
          width: 10,
          height: 10,
        },
        itemMargin: {
          horizontal: 0,
          vertical: 8
        }
    },
    plotOptions: {
      pie: {
        donut: {
          size: '80%',
          background: 'transparent',
          labels: {
            show: true,
            name: {
              show: true,
              fontSize: '26px',
              fontFamily: 'Nunito, sans-serif',
              color: undefined,
              offsetY: -10
            },
            value: {
              show: true,
              fontSize: '22px',
              fontFamily: 'Nunito, sans-serif',
              color: '#bfc9d4',
              offsetY: 16,
              formatter: function (val) {
                return val
              }
            },
            total: {
              show: true,
              showAlways: true,
              label: '453',
              color: '#000000',
              width: '40px',
              height: '40px',
              formatter: function (w) {
                return w.globals.seriesTotals.reduce( function(a, b) {
                  return a + b
                }, 0)
              }
            }
          }
        }
      }
    },
    stroke: {
      show: true,
      width:10
    },
    series: [985],
    responsive: [{
        breakpoint: 1599,
        options: {
            chart: {
                width: '200px',
                height: '200px'
            },
            legend: {
                position: 'bottom'
            }
        },

        breakpoint: 1439,
        options: {
            chart: {
                width: '120%',
                height: '220px'
            },
            legend: {
                position: 'bottom'
            },
            plotOptions: {
              pie: {
                donut: {
                  size: '70%',
                }
              }
            }
        },
    }]
}
var chartseaven = new ApexCharts(
    document.querySelector("#chartseaven"),
    chartseavenOptions
);

chartseaven.render();
/*
----------------------------------------------------------------------------
*/