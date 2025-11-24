// Chart js

var theme = {
  primary: 'var(--ds-primary)',
  secondary: 'var(--ds-secondary)',
  success: 'var(--ds-success)',
  info: 'var(--ds-info)',
  warning: 'var(--ds-warning)',
  danger: 'var(--ds-danger)',
  dark: 'var(--ds-dark)',
  light: 'var(--ds-light)',
  white: 'var(--ds-white)',
  infoDark: '#006C9C',
  successLight: '#77ED8B',
  gray100: 'var(--ds-gray-100)',
  gray200: 'var(--ds-gray-200)',
  gray300: 'var(--ds-gray-300)',
  gray400: 'var(--ds-gray-400)',
  gray500: 'var(--ds-gray-500)',
  gray600: 'var(--ds-gray-600)',
  gray700: 'var(--ds-gray-700)',
  gray800: 'var(--ds-gray-800)',
  gray900: 'var(--ds-gray-900)',
  black: 'var(--ds-black)',
  transparent: 'transparent',
};

// Add theme to the window object
window.theme = theme;

(function () {
  // Perfomance Chart

  if (document.getElementById('totalIncomeChart')) {
    var options = {
      series: [
        {
          name: 'Total Income',
          data: [31, 40, 28, 51, 42, 109, 100],
        },
      ],
      labels: ['Jan', 'Feb', 'March', 'April', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      chart: {
        height: 350,
        type: 'area',
        toolbar: {
          show: false,
        },
        fontFamily: 'Public Sans, serif',
      },
      dataLabels: {
        enabled: false,
      },
      markers: {
        size: 5,
        hover: {
          size: 6,
          sizeOffset: 3,
        },
      },
      colors: ['#00a76f'],
      stroke: {
        curve: 'smooth',
        width: 2,
      },
      grid: {
        show: true,
        borderColor: window.theme.gray300,
        strokeDashArray: 2,
      },
      xaxis: {
        labels: {
          show: true,
          align: 'right',
          minWidth: 0,
          maxWidth: 160,
          style: {
            fontSize: '12px',
            fontWeight: 400,
            colors: [window.theme.gray600],
            fontFamily: 'Public Sans, serif',
          },
        },
        axisBorder: {
          show: false,
          color: window.theme.gray300,
          height: 1,
          width: '100%',
          offsetX: 0,
          offsetY: 0,
        },
        axisTicks: {
          show: false,
          borderType: 'solid',
          color: window.theme.gray300,
          height: 6,
          offsetX: 0,
          offsetY: 0,
        },
      },
      legend: {
        show: false, // Disable built-in legend
      },
      yaxis: {
        labels: {
          formatter: function (e) {
            return e + 'k';
          },

          show: true,
          align: 'right',
          minWidth: 0,
          maxWidth: 160,
          style: {
            fontSize: '12px',
            fontWeight: 400,
            colors: window.theme.gray600,
            fontFamily: 'Public Sans, serif',
          },
        },
      },
    };
    var chart = new ApexCharts(document.querySelector('#totalIncomeChart'), options);
    chart.render();
  }

  if (document.getElementById('totalExpensesChart')) {
    var options = {
      series: [
        {
          name: 'Total Expenses',
          data: [11, 32, 45, 32, 34, 52, 41],
        },
      ],
      labels: ['Jan', 'Feb', 'March', 'April', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      chart: {
        height: 350,
        type: 'area',
        toolbar: {
          show: false,
        },
        fontFamily: 'Public Sans, serif',
      },
      grid: {
        show: true,
        borderColor: window.theme.gray300,
        strokeDashArray: 2,
      },
      dataLabels: {
        enabled: false,
      },
      markers: {
        size: 5,
        hover: {
          size: 6,
          sizeOffset: 3,
        },
      },
      colors: [window.theme.warning],
      stroke: {
        curve: 'smooth',
        width: 2,
      },

      xaxis: {
        labels: {
          show: true,
          align: 'right',
          minWidth: 0,
          maxWidth: 160,
          style: {
            fontSize: '12px',
            fontWeight: 400,
            colors: [window.theme.gray600],
            fontFamily: 'Public Sans, serif',
          },
        },
        axisBorder: {
          show: false,
          color: window.theme.gray300,
          height: 1,
          width: '100%',
          offsetX: 0,
          offsetY: 0,
        },
        axisTicks: {
          show: false,
          borderType: 'solid',
          color: window.theme.gray300,
          height: 6,
          offsetX: 0,
          offsetY: 0,
        },
      },
      legend: {
        show: false, // Disable built-in legend
      },
      yaxis: {
        labels: {
          formatter: function (e) {
            return e + 'k';
          },
          show: true,
          align: 'right',
          minWidth: 0,
          maxWidth: 160,
          style: {
            fontSize: '12px',
            fontWeight: 400,
            colors: window.theme.gray600,
            fontFamily: 'Public Sans, serif',
          },
        },
      },
    };
    var chart = new ApexCharts(document.querySelector('#totalExpensesChart'), options);
    chart.render();
  }

  // total sale donut chart
  if (document.getElementById('totalSale')) {
    var options = {
      series: [40, 30, 25, 10],
      labels: ['Smartphones', 'Laptops', 'Headphones', 'Cameras'],
      colors: [window.theme.primary, window.theme.warning, window.theme.info, window.theme.danger],
      chart: {
        type: 'donut',
        height: 377,
        fontFamily: 'Public Sans, serif',
      },
      legend: {
        show: false,
      },
      dataLabels: {
        enabled: true,
        dropShadow: {
          blur: 0,
          opacity: 0,
        },
      },
      plotOptions: {
        pie: {
          donut: {
            size: '65%',
          },
        },
      },
      stroke: {
        width: 0,
      },
      responsive: [
        {
          breakpoint: 1400,
          options: {
            chart: {
              type: 'donut',
              width: 290,
              height: 330,
            },
          },
        },
      ],
    };

    var chart = new ApexCharts(document.querySelector('#totalSale'), options);
    chart.render();
  }

  // location map
  if (document.getElementById('map-world')) {
    const map = new jsVectorMap({
      selector: '#map-world',
      map: 'world',
      backgroundColor: 'transparent',
      regionStyle: {
        initial: {
          fill: window.theme.gray300,
          stroke: window.theme.gray300,
          strokeWidth: 2,
        },
      },
      zoomOnScroll: false,
      zoomButtons: false,
      // -------- Series --------
      visualizeData: {
        scale: ['#fcfdfd', '#c4cdd5', '#ff0000'], // Define a color scale
        values: {
          AF: 16,
          AL: 11,
          DZ: 158,
          AO: 85,
          AG: 1,
          AR: 351,
          AM: 8,
          AU: 1219,
          AT: 366,
          AZ: 52,
          BS: 7,
          BH: 21,
          BD: 105,
          BB: 3,
          BY: 52,
          BE: 461,
          BZ: 1,
          BJ: 6,
          BT: 1,
          BO: 19,
          BA: 16,
          BW: 12,
          BR: 2023,
          BN: 11,
          BG: 44,
          BF: 8,
          BI: 1,
          KH: 11,
          CM: 21,
          CA: 1563,
          CV: 1,
          CF: 2,
          TD: 7,
          CL: 199,
          CN: 5745,
          CO: 283,
          KM: 0,
          CD: 12,
          CG: 11,
          CR: 35,
          CI: 22,
          HR: 59,
          CY: 22,
          CZ: 195,
          DK: 304,
          DJ: 1,
          DM: 0,
          DO: 50,
          EC: 61,
          EG: 216,
          SV: 21,
          GQ: 14,
          ER: 2,
          EE: 19,
          ET: 30,
          FJ: 3,
          FI: 231,
          FR: 2555,
          GA: 12,
          GM: 1,
          GE: 11,
          DE: 3305,
          GH: 18,
          GR: 305,
          GD: 0,
          GT: 40,
          GN: 4,
          GW: 0,
          GY: 2,
          HT: 6,
          HN: 15,
          HK: 226,
          HU: 132,
          IS: 12,
          IN: 10000,
          ID: 695,
          IR: 337,
          IQ: 84,
          IE: 204,
          IL: 201,
          IT: 2036,
          JM: 13,
          JP: 5390,
          JO: 27,
          KZ: 129,
          KE: 32,
          KI: 0,
          KR: 986,
          KW: 117,
          KG: 4,
          LA: 6,
          LV: 23,
          LB: 39,
          LS: 1,
          LR: 0,
          LY: 77,
          LT: 35,
          LU: 52,
          MK: 9,
          MG: 8,
          MW: 5,
          MY: 218,
          MV: 1,
          ML: 9,
          MT: 7,
          MR: 3,
          MU: 9,
          MX: 1004,
          MD: 5,
          MN: 5,
          ME: 3,
          MA: 91,
          MZ: 10,
          MM: 35,
          NA: 11,
          NP: 15,
          NL: 770,
          NZ: 138,
          NI: 6,
          NE: 5,
          NG: 206,
          NO: 413,
          OM: 53,
          PK: 174,
          PA: 27,
          PG: 8,
          PY: 17,
          PE: 153,
          PH: 189,
          PL: 438,
          PT: 223,
          QA: 126,
          RO: 158,
          RU: 1476,
          RW: 5,
          WS: 0,
          ST: 0,
          SA: 434,
          SN: 12,
          RS: 38,
          SC: 0,
          SL: 1,
          SG: 217,
          SK: 86,
          SI: 46,
          SB: 0,
          ZA: 354,
          ES: 1374,
          LK: 48,
          KN: 0,
          LC: 1,
          VC: 0,
          SD: 65,
          SR: 3,
          SZ: 3,
          SE: 444,
          CH: 522,
          SY: 59,
          TW: 426,
          TJ: 5,
          TZ: 22,
          TH: 312,
          TL: 0,
          TG: 3,
          TO: 0,
          TT: 21,
          TN: 43,
          TR: 729,
          TM: 0,
          UG: 17,
          UA: 136,
          AE: 239,
          GB: 2258,
          US: 4624,
          UY: 40,
          UZ: 37,
          VU: 0,
          VE: 285,
          VN: 101,
          YE: 30,
          ZM: 15,
          ZW: 5,
        },
      },
    });
    window.addEventListener('resize', () => {
      map.updateSize();
    });
  }

  if (document.getElementById('chartGraphics')) {
    var options = {
      series: [
        {
          name: 'Male',
          data: [44, 55, 57, 56, 61, 58],
        },
        {
          name: 'Female',
          data: [76, 85, 101, 98, 87, 105],
        },
      ],
      chart: {
        type: 'bar',
        height: 260,
        toolbar: {
          show: false,
        },
        fontFamily: 'Public Sans, serif',
      },
      colors: [window.theme.warning, window.theme.primary],
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '30%',
          endingShape: 'rounded',
        },
      },
      dataLabels: {
        enabled: false,
      },
      legend: {
        show: false,
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent'],
      },

      xaxis: {
        categories: ['18-35', '25-34', '35-44', '45-54', '55-64', '65+'],
        axisBorder: {
          show: false,
        },
        axisTicks: {
          show: false,
        },
        labels: {
          show: true,
          align: 'right',
          minWidth: 0,
          maxWidth: 160,
          style: {
            fontSize: '12px',
            fontWeight: 400,
            colors: window.theme.gray600,
            fontFamily: 'Public Sans, serif',
          },
        },
      },
      yaxis: {
        labels: {
          show: true,
          align: 'right',
          minWidth: 0,
          maxWidth: 160,
          style: {
            fontSize: '12px',
            fontWeight: 400,
            colors: window.theme.gray600,
            fontFamily: 'Public Sans, serif',
          },
        },
      },
      grid: {
        show: false,
        borderColor: window.theme.gray300,
      },
      fill: {
        opacity: 1,
      },
      tooltip: {
        y: {},
      },
    };

    var chart = new ApexCharts(document.querySelector('#chartGraphics'), options);
    chart.render();
  }
  // progress chart

  if (document.getElementById('salesBygender')) {
    var options = {
      series: [44, 55, 67],
      chart: {
        height: 350,
        type: 'radialBar',
      },
      colors: ['#5BE49B', '#FFF5CC', '#FFE9D5'],
      plotOptions: {
        radialBar: {
          dataLabels: {
            name: {
              fontSize: '22px',
            },
            value: {
              fontSize: '16px',
            },
            total: {
              show: false,
            },
          },
          hollow: {
            margin: 3,
            size: '40%',
            background: 'transparent',
            image: undefined,
            imageWidth: 150,
            imageHeight: 150,
            imageOffsetX: 0,
            imageOffsetY: 0,
            imageClipped: true,
            position: 'front',
            dropShadow: {
              enabled: false,
              top: 0,
              left: 0,
              blur: 3,
              opacity: 0.5,
            },
          },
          track: {
            show: true,
            startAngle: undefined,
            endAngle: undefined,
            background: window.theme.gray300,
            strokeWidth: '45%',
            opacity: 1,
            margin: 5,
            dropShadow: {
              enabled: false,
              top: 0,
              left: 0,
              blur: 3,
              opacity: 0.5,
            },
          },
        },
      },
      fill: {
        type: 'gradient',
        gradient: {
          shade: 'dark',
          type: 'vertical',
          gradientToColors: ['#007867', '#FFD666', '#FFAC82'],
          stops: [0, 100],
        },
      },
      stroke: {
        lineCap: 'round',
      },

      labels: ['Men', 'Womens', 'Kids'],
    };

    var chart = new ApexCharts(document.querySelector('#salesBygender'), options);
    chart.render();
  }
  if (document.getElementById('leadWonLoss')) {
    var options = {
      series: [
        {
          name: 'Won',
          data: [44, 55, 57, 56, 61, 58, 63, 60, 66],
        },
        {
          name: 'Lost',
          data: [76, 85, 101, 98, 87, 105, 91, 114, 94],
        },
        {
          name: 'Open',
          data: [35, 41, 36, 26, 45, 48, 52, 53, 41],
        },
      ],
      colors: ['#cafdf5', '#61f3f3', '#006c9c'],
      chart: {
        type: 'bar',
        height: 350,
        toolbar: {
          show: false,
        },
      },
      grid: {
        show: true,
        borderColor: window.theme.gray300,
        strokeDashArray: 2,
      },
      legend: {
        show: true,
        fontFamily: 'Public Sans, serif',
        fontWeight: 500,
        markers: {
          size: 5,
          shape: 'square',
          strokeWidth: 0,
          fillColors: undefined,
          customHTML: undefined,
          onClick: undefined,
          offsetX: -2,
          offsetY: 0,
        },
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '85%',
          borderRadius: 3,
          borderRadiusApplication: 'end',
        },
      },
      dataLabels: {
        enabled: false,
      },
      stroke: {
        show: false,
        width: 2,
        colors: ['transparent'],
      },
      xaxis: {
        categories: ['28 Jan', '29 Jan', '30 Jan', '31 Jan', '1 Feb', '2 Feb', '3 Feb', '4 Feb', '5 Feb'],
        axisBorder: {
          show: false,
          color: window.theme.gray300,
          height: 1,
          width: '100%',
          offsetX: 0,
          offsetY: 0,
        },
        axisTicks: {
          show: false,
          borderType: 'solid',
          color: window.theme.gray300,
          height: 6,
          offsetX: 0,
          offsetY: 0,
        },
      },

      yaxis: {
        title: {},
      },
      fill: {
        opacity: 1,
      },
      tooltip: {},
    };

    var chart = new ApexCharts(document.querySelector('#leadWonLoss'), options);
    chart.render();
  }

  if (document.getElementById('chartCompany')) {
    var options = {
      series: [
        {
          name: 'Companies',
          data: [44, 35, 57, 26, 61, 38, 54, 78, 84, 32],
        },
      ],
      chart: {
        type: 'bar',
        height: 60,
        sparkline: {
          enabled: !0,
        },
        fontFamily: 'Public Sans, serif',
      },

      colors: [window.theme.primary],
      plotOptions: {
        bar: {
          columnWidth: '40%',
          borderRadius: 4,
          borderRadiusApplication: 'end',
          horizontal: false,
        },
      },
      xaxis: {
        crosshairs: {
          width: 1,
        },
      },
      tooltip: {
        fixed: {
          enabled: !1,
        },
        x: {
          show: !1,
        },
      },
    };

    var chart = new ApexCharts(document.querySelector('#chartCompany'), options);
    chart.render();
  }
  if (document.getElementById('chartLead')) {
    var options = {
      series: [
        {
          name: 'Contacts',
          data: [25, 66, 41, 89, 63, 25, 44, 12, 36, 9, 54],
        },
      ],
      chart: {
        type: 'line',
        height: 60,
        sparkline: {
          enabled: !0,
        },
        fontFamily: 'Public Sans, serif',
      },

      stroke: {
        width: 2,
        curve: 'smooth',
      },
      markers: {
        size: 0,
      },
      colors: [window.theme.info],
      tooltip: {
        fixed: {
          enabled: !1,
        },
        x: {
          show: !1,
        },
      },
    };

    var chart = new ApexCharts(document.querySelector('#chartLead'), options);
    chart.render();
  }
  if (document.getElementById('chartDeals')) {
    var options = {
      series: [
        {
          name: 'Deals',
          data: [44, 105, 57, 99, 71, 48, 54, 88, 65, 44],
        },
      ],
      chart: {
        type: 'bar',
        height: 60,
        sparkline: {
          enabled: !0,
        },
      },
      colors: [window.theme.warning],
      plotOptions: {
        bar: {
          columnWidth: '40%',
          borderRadius: 4,
          borderRadiusApplication: 'end',
          horizontal: false,
        },
      },
      xaxis: {
        crosshairs: {
          width: 1,
        },
      },
      tooltip: {
        fixed: {
          enabled: !1,
        },
        x: {
          show: !1,
        },
      },
    };

    var chart = new ApexCharts(document.querySelector('#chartDeals'), options);
    chart.render();
  }

  if (document.getElementById('chartBooked')) {
    var options = {
      series: [
        {
          name: 'Revenue',
          data: [44, 105, 57, 99, 71, 48, 54, 88, 65, 44],
        },
      ],
      chart: {
        type: 'bar',
        height: 60,
        sparkline: {
          enabled: !0,
        },
        fontFamily: 'Public Sans, serif',
      },
      colors: [window.theme.info],
      plotOptions: {
        bar: {
          columnWidth: '40%',
          borderRadius: 4,
          borderRadiusApplication: 'end',
          horizontal: false,
        },
      },
      xaxis: {
        crosshairs: {
          width: 1,
        },
      },
      tooltip: {
        fixed: {
          enabled: !1,
        },
        x: {
          show: !1,
        },
      },
    };

    var chart = new ApexCharts(document.querySelector('#chartBooked'), options);
    chart.render();
  }

  if (document.getElementById('contactSource')) {
    var options = {
      series: [50, 30, 10, 10],
      chart: {
        width: 380,
        type: 'pie',
      },
      labels: ['Website', 'Social Media', 'Referrals', 'Emails'],
      colors: [window.theme.primary, window.theme.warning, window.theme.infoDark, window.theme.danger],
      stroke: {
        show: true,
        curve: 'straight',
        lineCap: 'butt',
        colors: window.theme.gray200,
        width: 2,
        dashArray: 0,
      },
      plotOptions: {
        pie: {
          startAngle: -90, // Start angle to position the 50% slice at the top
          endAngle: 270, // End angle to complete the circle
          expandOnClick: true,
          offset: 10, // Pull out the slice
          customScale: 1,
          dataLabels: {
            offset: 0,
            minAngleToShowLabel: 10,
          },
        },
      },
      legend: {
        position: 'bottom',
        fontFamily: 'Public Sans, serif',
        fontWeight: 500,
        markers: {
          size: 4,
          shape: undefined,
          strokeWidth: 0,
          fillColors: undefined,
          customHTML: undefined,
          onClick: undefined,
          offsetX: -2,
          offsetY: 0,
        },
      },

      responsive: [
        {
          breakpoint: 480,
          options: {
            chart: {
              width: 200,
            },
            legend: {
              position: 'bottom',
            },
          },
        },
      ],
    };

    var chart = new ApexCharts(document.querySelector('#contactSource'), options);
    chart.render();
  }

  // progress chart
  if (document.getElementById('progressChart')) {
    var options = {
      series: [75],
      chart: {
        height: 350,
        type: 'radialBar',
        toolbar: {
          show: false,
        },
        fontFamily: 'Public Sans, serif',
      },
      colors: [window.theme.primary, window.theme.success],
      plotOptions: {
        radialBar: {
          startAngle: -135,
          endAngle: 225,
          hollow: {
            margin: 0,
            size: '70%',
            background: window.theme.white,
            image: undefined,
            imageOffsetX: 0,
            imageOffsetY: 0,
            position: 'front',
            dropShadow: {
              enabled: true,
              top: 3,
              left: 0,
              blur: 4,
              opacity: 0.24,
            },
          },
          track: {
            background: window.theme.white,
            strokeWidth: '67%',
            margin: 0, // margin is in pixels
            dropShadow: {
              enabled: true,
              top: -3,
              left: 0,
              blur: 4,
              opacity: 0.35,
            },
          },

          dataLabels: {
            showOn: 'always',

            name: {
              show: false,
            },
            value: {
              formatter: function (val) {
                return parseInt(val) + '%';
              },
              color: window.theme.gray800,
              fontSize: '48px',
              fontWeight: '700',
              show: true,
            },
          },
        },
      },
      fill: {
        type: 'gradient',
        gradient: {
          shade: 'dark',
          type: 'horizontal',
          shadeIntensity: 0.5,
          gradientToColors: [window.theme.info],
          inverseColors: false,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 100],
        },
      },
      stroke: {
        lineCap: 'round',
      },
    };

    var chart = new ApexCharts(document.querySelector('#progressChart'), options);
    chart.render();
  }
  // task summary chart
  if (document.getElementById('taskSummary')) {
    var options = {
      series: [
        {
          name: 'Closed',
          type: 'column',
          data: [12, 18, 20, 32, 19, 25, 30],
        },
        {
          name: 'New',
          type: 'line',
          data: [20, 32, 28, 50, 38, 35, 49],
        },
      ],
      chart: {
        height: 350,
        type: 'line',
        toolbar: {
          show: false,
        },

        fontFamily: 'Public Sans, serif',
      },

      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: '40%',
          borderRadius: 5,
        },
      },
      markers: {
        colors: ['#161C24'],
        fillColor: '#F4F6F8',
      },
      colors: [window.theme.info],
      legend: {
        show: false,
      },
      stroke: {
        width: [0, 4],
        colors: ['#cafdf5'],
      },
      dataLabels: {
        enabled: true,
        enabledOnSeries: [1],
      },

      labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      xaxis: {
        axisBorder: {
          show: false,
        },
        axisTicks: {
          show: true,
          borderType: 'solid',
          color: window.theme.gray400,
          width: 6,
          offsetX: 0,
          offsetY: 0,
        },
        labels: {
          offsetX: 0,
          offsetY: 5,
          style: {
            fontSize: '13px',
            fontWeight: 400,
            fontFamily: 'Public Sans, serif',
            colors: [window.theme.gray800],
          },
        },
      },
      grid: {
        borderColor: window.theme.gray300,
        strokeDashArray: 3,
        xaxis: {
          lines: {
            show: false,
          },
        },
        yaxis: {
          lines: {
            show: true,
          },
        },
        padding: {
          top: 0,
          right: 0,
          bottom: 0,
          left: -10,
        },
      },
      yaxis: {
        title: {
          text: undefined,
        },
        plotOptions: {
          bar: {
            horizontal: false,
            endingShape: 'rounded',
            columnWidth: '80%',
          },
        },

        labels: {
          style: {
            fontSize: '13px',
            fontWeight: 400,
            fontFamily: 'Public Sans, serif',
            colors: [window.theme.gray800],
          },
          offsetX: -10,
        },
      },
    };

    var chart = new ApexCharts(document.querySelector('#taskSummary'), options);
    chart.render();
  }

  // task status chart
  if (document.getElementById('taskStatus')) {
    var options = {
      dataLabels: {
        enabled: false,
      },
      series: [75, 25],
      labels: ['Completed', 'Incomplete'],
      colors: [window.theme.primary, window.theme.warning],
      chart: {
        width: 480,
        type: 'donut',
        fontFamily: 'Public Sans, serif',
      },
      stroke: {
        show: true,

        colors: [window.theme.transparent],
      },

      plotOptions: {
        pie: {
          expandOnClick: false,
          donut: {
            size: '75%',
          },
        },
      },
      legend: {
        position: 'bottom',
        fontFamily: 'Public Sans, serif',
        fontWeight: 500,
        fontSize: '14px',

        labels: {
          colors: window.theme.gray500,
          useSeriesColors: false,
        },
        markers: {
          width: 8,
          height: 8,
          strokeWidth: 0,
          strokeColor: window.theme.gray600,
          fillColors: undefined,
          radius: 12,
          customHTML: undefined,
          onClick: undefined,
          offsetX: -2,
          offsetY: 1,
        },
        itemMargin: {
          horizontal: 8,
          vertical: 0,
        },
      },
      tooltip: {
        theme: 'light',
        marker: {
          show: true,
        },
        x: {
          show: false,
        },
      },
      states: {
        hover: {
          filter: {
            type: 'none',
          },
        },
      },
      responsive: [
        {
          breakpoint: 1400,
          options: {
            chart: {
              type: 'donut',
              width: 290,
              height: 410,
            },
          },
        },
      ],
    };

    var chart = new ApexCharts(document.querySelector('#taskStatus'), options);
    chart.render();
  }
  // section chart
  if (document.getElementById('taskSectionchart')) {
    var options = {
      series: [44, 65, 89, 75],
      chart: {
        height: 400,
        type: 'radialBar',
        fontFamily: 'Public Sans, serif',
      },
      legend: {
        show: true,
        fontSize: '12px',
        fontFamily: 'Inter',
        fontWeight: 500,
        position: 'bottom',
        itemMargin: {
          horizontal: 8,
          vertical: 0,
        },
        labels: {
          colors: window.theme.gray800,
          useSeriesColors: false,
        },
        markers: {
          size: 5,
          offsetY: 1,
          offsetX: -2,
        },
      },
      plotOptions: {
        radialBar: {
          dataLabels: {
            name: {},
            value: {
              fontSize: '24px',
              fontWeight: 600,
              color: window.theme.gray800,
              formatter: function (val) {
                return val;
              },
            },
            total: {
              show: true,
              label: 'Total',
              fontSize: '12px',
              color: window.theme.gray600,
              formatter: function (w) {
                // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                return 273;
              },
            },
          },
          track: {
            background: window.theme.gray300,
            margin: 10,
          },
        },
      },
      labels: ['Design', 'Frontend', 'Development', 'Issues'],
      colors: [window.theme.primary, window.theme.danger, window.theme.info, window.theme.warning],
    };

    var chart = new ApexCharts(document.querySelector('#taskSectionchart'), options);
    chart.render();
  }

  // prototype chart
  if (document.getElementsByClassName('taskPrototypeChart').length > 0) {
    var options = {
      series: [75],
      chart: {
        height: 18,
        width: 60,
        type: 'radialBar',
        fontFamily: 'Public Sans, serif',
      },
      grid: {
        show: false,
        padding: {
          left: -15,
          right: -15,
          top: -12,
          bottom: -15,
        },
      },
      colors: [window.theme.info],
      plotOptions: {
        radialBar: {
          hollow: {
            size: '40%',
          },

          dataLabels: {
            showOn: 'always',
            name: {
              show: true,
              fontSize: '11px',
              fontFamily: undefined,
              fontWeight: 600,
              color: undefined,
              offsetY: 4,
            },
            value: {
              show: false,
            },
          },
          track: {
            background: window.theme.gray300,
          },
        },
      },
      stroke: {
        lineCap: 'round',
      },
      labels: ['75%'],
    };
    var chart = new ApexCharts(document.querySelector('.taskPrototypeChart'), options);
    chart.render();
  }

  // task Content chart
  if (document.getElementsByClassName('taskContentChart').length > 0) {
    var options = {
      series: [85],
      chart: {
        height: 18,
        width: 60,
        type: 'radialBar',
        fontFamily: 'Public Sans, serif',
      },
      grid: {
        show: false,
        padding: {
          left: -15,
          right: -15,
          top: -12,
          bottom: -15,
        },
      },
      colors: [window.theme.danger],
      plotOptions: {
        radialBar: {
          hollow: {
            size: '40%',
          },

          dataLabels: {
            showOn: 'always',
            name: {
              show: true,
              fontSize: '11px',
              fontFamily: undefined,
              fontWeight: 600,
              color: undefined,
              offsetY: 4,
            },
            value: {
              show: false,
            },
          },
          track: {
            background: window.theme.gray300,
          },
        },
      },
      stroke: {
        lineCap: 'round',
      },
      labels: ['85%'],
    };
    var chart = new ApexCharts(document.querySelector('.taskContentChart'), options);
    chart.render();
  }

  // task Figma chart
  if (document.getElementsByClassName('taskFigmaChart').length > 0) {
    var options = {
      series: [40],
      chart: {
        height: 18,
        width: 60,
        type: 'radialBar',
        fontFamily: 'Public Sans, serif',
      },
      grid: {
        show: false,
        padding: {
          left: -15,
          right: -15,
          top: -12,
          bottom: -15,
        },
      },
      colors: [window.theme.warning],
      plotOptions: {
        radialBar: {
          hollow: {
            size: '40%',
          },

          dataLabels: {
            showOn: 'always',
            name: {
              show: true,
              fontSize: '11px',
              fontFamily: undefined,
              fontWeight: 600,
              color: undefined,
              offsetY: 4,
            },
            value: {
              show: false,
            },
          },
          track: {
            background: window.theme.gray300,
          },
        },
      },
      stroke: {
        lineCap: 'round',
      },
      labels: ['40%'],
    };
    var chart = new ApexCharts(document.querySelector('.taskFigmaChart'), options);
    chart.render();
  }

  // task Interface chart
  if (document.getElementsByClassName('taskInterfaceChart').length > 0) {
    var options = {
      series: [35],
      chart: {
        height: 18,
        width: 60,
        type: 'radialBar',
        fontFamily: 'Public Sans, serif',
      },
      grid: {
        show: false,
        padding: {
          left: -15,
          right: -15,
          top: -12,
          bottom: -15,
        },
      },
      colors: [window.theme.primary],
      plotOptions: {
        radialBar: {
          hollow: {
            size: '40%',
          },

          dataLabels: {
            showOn: 'always',
            name: {
              show: true,
              fontSize: '11px',
              fontFamily: undefined,
              fontWeight: 600,
              color: undefined,
              offsetY: 4,
            },
            value: {
              show: false,
            },
          },
          track: {
            background: window.theme.gray300,
          },
        },
      },
      stroke: {
        lineCap: 'round',
      },
      labels: ['35%'],
    };
    var chart = new ApexCharts(document.querySelector('.taskInterfaceChart'), options);
    chart.render();
  }

  // task Wireframe chart
  if (document.getElementsByClassName('taskWireframeChart').length > 0) {
    var options = {
      series: [65],
      chart: {
        height: 18,
        width: 60,
        type: 'radialBar',
        fontFamily: 'Public Sans, serif',
      },
      grid: {
        show: false,
        padding: {
          left: -15,
          right: -15,
          top: -12,
          bottom: -15,
        },
      },
      colors: [window.theme.success],

      plotOptions: {
        radialBar: {
          hollow: {
            size: '40%',
          },

          dataLabels: {
            showOn: 'always',
            name: {
              show: true,
              fontSize: '11px',
              fontFamily: undefined,
              fontWeight: 600,
              color: undefined,
              offsetY: 4,
            },
            value: {
              show: false,
            },
          },
          track: {
            background: window.theme.gray300,
          },
        },
      },
      stroke: {
        lineCap: 'round',
      },
      labels: ['65%'],
    };
    var chart = new ApexCharts(document.querySelector('.taskWireframeChart'), options);
    chart.render();
  }

  // budget Expense chart
  if (document.getElementById('budgetExpenseChart')) {
    var options = {
      series: [
        {
          name: 'Series 1',
          data: [90, 32, 30, 40, 100, 20],
        },
      ],
      stroke: {
        show: true,
        width: 2,
        colors: [window.theme.primary],
        dashArray: 0,
      },
      fill: {
        colors: '#5be49b',
        opacity: 0.5,
      },
      colors: [window.theme.primary],
      dataLabels: {
        enabled: true,
        background: {
          enabled: true,
          borderRadius: 2,
        },
      },
      chart: {
        height: 350,
        type: 'radar',
        toolbar: {
          show: false,
        },
        fontFamily: 'Public Sans, serif',
      },

      plotOptions: {
        radar: {
          size: 150,
          offsetX: 0,
          offsetY: 0,
          polygons: {
            strokeColors: window.theme.gray300,
            strokeWidth: 1,
            connectorColors: window.theme.gray300,
            fill: {
              colors: undefined,
            },
          },
        },
      },
      xaxis: {
        categories: ['Design', 'SaaS Services', 'Development', 'SEO', 'Entertainment', 'Marketing'],

        labels: {
          show: true,

          style: {
            colors: window.theme.primary,
            fontSize: '14px',
            fontFamily: 'Inter',
            fontWeight: 600,
          },
        },
      },
    };

    var chart = new ApexCharts(document.querySelector('#budgetExpenseChart'), options);
    chart.render();
  }

  // new 20/01/2025
  if (document.getElementById('userByCountry')) {
    var options = {
      series: [94, 55, 13, 43],
      chart: {
        width: 380,
        type: 'pie',
        fontFamily: 'Public Sans, serif',
      },
      labels: ['US', 'India', 'UK', 'Russia'],
      colors: [window.theme.primary, window.theme.info, window.theme.warning, window.theme.success],
      responsive: [
        {
          breakpoint: 480,
          options: {
            chart: {
              width: 400,
            },
          },
        },
      ],
      legend: {
        position: 'bottom',
        markers: {
          size: 4,
          shape: 'circle',
          strokeWidth: 0,
          strokeOpacity: 1,
          offsetX: -2,
        },

        itemMargin: {
          horizontal: 8,
          vertical: 4,
        },
      },
      stroke: {
        show: true,
        curve: 'straight',
        lineCap: 'butt',
        colors: [window.theme.gray100],
        width: 2,
        dashArray: 0,
      },

      plotOptions: {
        pie: {
          donut: {
            labels: {
              show: false,
              total: {
                show: false,
                label: 'Total',
                formatter: function (w) {
                  return w.globals.seriesTotals.reduce((a, b) => {
                    return a + b;
                  }, 0);
                },
              },
            },
          },
        },
      },
      dataLabels: {
        enabled: false,
      },
    };
    var chart = new ApexCharts(document.getElementById('userByCountry'), options);
    chart.render();
  }
  if (document.getElementById('trafficSummary')) {
    var options = {
      chart: {
        type: 'bar',
        fontFamily: 'Public Sans, serif',
        height: 280,
        parentHeightOffset: 0,
        toolbar: {
          show: false,
        },
        animations: {
          enabled: false,
        },
        stacked: true,
      },
      plotOptions: {
        bar: {
          columnWidth: '50%',
          horizontal: false,
        },
      },
      dataLabels: {
        enabled: false,
      },
      fill: {
        opacity: 1,
      },
      markers: {
        size: 4,
        colors: undefined,
        strokeColors: '#fff',
        strokeWidth: 0,
        strokeOpacity: 0,
        strokeDashArray: 0,
        fillOpacity: 1,
        discrete: [],
        shape: 'square',
        offsetX: 0,
        offsetY: 0,
        onClick: undefined,
        onDblClick: undefined,
        showNullDataPoints: true,
        hover: {
          size: undefined,
          sizeOffset: 3,
        },
      },
      series: [
        {
          name: 'Web',
          data: [11, 20, 20, 20, 20, 11, 11, 20, 20, 10, 12, 12, 15, 18, 22, 16, 18, 16, 14, 11, 18, 24, 29, 51, 40, 47, 23, 26, 50, 26, 41, 22, 46, 47, 81, 46, 16],
        },
        {
          name: 'Social',
          data: [2, 5, 4, 3, 3, 1, 4, 7, 5, 1, 2, 5, 3, 2, 6, 7, 7, 1, 5, 5, 2, 12, 4, 6, 18, 3, 5, 2, 13, 15, 20, 47, 18, 15, 11, 10, 0],
        },
        {
          name: 'Other',
          data: [2, 9, 1, 7, 8, 3, 6, 5, 5, 4, 6, 4, 1, 9, 3, 6, 7, 5, 2, 8, 4, 9, 1, 2, 6, 7, 5, 1, 8, 3, 2, 3, 4, 9, 7, 1, 6],
        },
      ],
      tooltip: {
        theme: 'dark',
      },
      grid: {
        padding: {
          top: -20,
          right: 0,
          left: -4,
          bottom: -4,
        },
        borderColor: window.theme.gray300,
        strokeDashArray: 2,
        xaxis: {
          lines: {
            show: true,
          },
        },
      },
      xaxis: {
        labels: {
          padding: 0,
        },
        tooltip: {
          enabled: false,
        },
        axisBorder: {
          show: false,
        },
        type: 'datetime',
      },
      yaxis: {
        labels: {
          padding: 4,
        },
      },
      labels: [
        '2025-06-21',
        '2025-06-22',
        '2025-06-23',
        '2025-06-24',
        '2025-06-25',
        '2025-06-26',
        '2025-06-27',
        '2025-06-28',
        '2025-06-29',
        '2025-06-30',
        '2025-07-01',
        '2025-07-02',
        '2025-07-03',
        '2025-07-04',
        '2025-07-05',
        '2025-07-06',
        '2025-07-07',
        '2025-07-08',
        '2025-07-09',
        '2025-07-10',
        '2025-07-11',
        '2025-07-12',
        '2025-07-13',
        '2025-07-14',
        '2025-07-15',
        '2025-07-16',
        '2025-07-17',
        '2025-07-18',
        '2025-07-19',
        '2025-07-20',
        '2025-07-21',
        '2025-07-22',
        '2025-07-23',
        '2025-07-24',
        '2025-07-25',
        '2025-07-26',
        '2025-07-27',
      ],
      colors: [window.theme.infoDark, window.theme.info, window.theme.successLight],
      legend: {
        show: true,
      },
    };
    var chart = new ApexCharts(document.getElementById('trafficSummary'), options);
    chart.render();
  }

  if (document.getElementById('subscribeChart')) {
    var options = {
      chart: {
        type: 'bar',
        fontFamily: 'Public Sans, serif',

        height: 400,

        toolbar: {
          show: false,
        },
        animations: {
          enabled: false,
        },
        stacked: true,
      },

      plotOptions: {
        bar: {
          columnWidth: '35%',
          horizontal: false,
        },
      },
      dataLabels: {
        enabled: false,
      },
      fill: {
        opacity: 1,
      },

      series: [
        {
          name: 'Paid Subscriber',
          data: [30, 42, 56, 46, 30, 22, 42, 36, 58, 69, 45, 55],
        },
        {
          name: 'Trial Started',
          data: [11, 30, 40, 60, 50, 45, 85, 30, 45, 60, 80, 20],
        },
        {
          name: 'Unsubscribed',
          data: [22, 42, 36, 58, 69, 45, 55, 11, 20, 20, 10, 45],
        },
      ],
      tooltip: {
        theme: 'dark',
      },

      grid: {
        padding: {
          top: -20,
          right: 0,
          left: -4,
          bottom: -4,
        },
        borderColor: window.theme.gray300,
        strokeDashArray: 2,
        xaxis: {
          lines: {
            show: true,
          },
        },
      },
      xaxis: {
        labels: {
          padding: 0,
        },
        tooltip: {
          enabled: false,
        },
        axisBorder: {
          show: false,
        },
        type: 'datetime',
      },
      yaxis: {
        labels: {
          padding: 4,
        },
      },
      labels: [
        '01/01/2011 GMT',
        '01/02/2011 GMT',
        '01/03/2011 GMT',
        '01/04/2011 GMT',
        '01/05/2011 GMT',
        '01/06/2011 GMT',
        '01/07/2011 GMT',
        '01/08/2011 GMT',
        '01/09/2011 GMT',
        '01/10/2011 GMT',
        '01/11/2011 GMT',
        '01/12/2011 GMT',
      ],
      colors: ['#7a0916', '#b71d18', '#ffe9d5'],
      legend: {
        position: 'top',
        show: false,
      },
    };
    var chart = new ApexCharts(document.getElementById('subscribeChart'), options);
    chart.render();
  }
  if (document.getElementById('dealsRep')) {
    var options = {
      series: [
        {
          name: 'Deals Rep',
          data: [8, 10, 12, 18, 29, 35],
        },
      ],
      chart: {
        type: 'bar',
        height: 350,
        toolbar: {
          show: false,
        },
      },

      colors: ['#ffac82'],
      grid: {
        show: true,
        borderColor: window.theme.gray300,
        strokeDashArray: 2,
      },
      plotOptions: {
        bar: {
          borderRadius: 0,
          borderRadiusApplication: 'end',
          horizontal: true,
        },
      },
      dataLabels: {
        enabled: false,
      },

      xaxis: {
        categories: ['Jessica Parker', 'Michael Smith', 'Emily Johnson', 'Noah Miller', 'Jitu Chauhan', 'Anita parmar'],
        axisBorder: {
          show: false,
          color: '#78909C',
          offsetX: 0,
          offsetY: 0,
        },
        axisTicks: {
          show: false,
          borderType: 'solid',
          color: '#78909C',
          width: 6,
          offsetX: 0,
          offsetY: 0,
        },
      },
    };

    var chart = new ApexCharts(document.querySelector('#dealsRep'), options);
    chart.render();
  }
  if (document.getElementById('expenseCategory')) {
    var options = {
      series: [14, 23, 21, 17, 15, 10, 17, 21],
      chart: {
        type: 'polarArea',
      },
      stroke: {
        colors: [window.theme.gray200],
      },

      labels: ['Food', 'Transportation', 'Fuel', 'Household Items', 'Clothing', 'Entertainment', 'Medical', 'Education'],
      colors: ['#00B8D9', '#065e49', '#B76E00', '#B71D18', '#007867', '#006C9C', '#22C55E', '#FFAB00', '#FF5630'],
      fill: {
        opacity: 1,
      },
      legend: {
        show: false,
      },
      plotOptions: {
        polarArea: {
          rings: {
            strokeWidth: 1,
            strokeColor: window.theme.gray300,
          },
          spokes: {
            strokeWidth: 1,
            connectorColors: window.theme.gray300,
          },
        },
      },

      responsive: [
        {
          breakpoint: 480,
          options: {
            chart: {
              width: 400,
            },
            legend: {
              position: 'bottom',
            },
          },
        },
      ],
    };

    var chart = new ApexCharts(document.querySelector('#expenseCategory'), options);
    chart.render();
  }
})();
