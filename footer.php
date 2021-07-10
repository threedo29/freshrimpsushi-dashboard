    <!--<footer>
        <div>
            <p style="text-align: center">
                &copy; 2021. <a href="https://freshrimpsushi.github.io" target="_blank">생새우초밥집</a> all rights reserved.
            </p>
        </div>
    </footer>-->
    
<!-- <script async='async' src='https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS_CHTML,Safe' type='text/javascript'>
MathJax.Hub.Config({
    messageStyle: "none",
    jax: ["input/TeX", "output/HTML-CSS"],
    "HTML-CSS": { availableFonts: ["TeX"] },
    extensions: ["tex2jax.js","TeX/AMSmath.js","TeX/AMSsymbols.js"],

    tex2jax: {
        inlineMath: [ ['$','$'], ["\\(","\\)"] ],
        displayMath: [ ['$$','$$'], ["\\(","\\)"] ],
        displayAlign: "left"
    },
    
    TeX: { equationNumbers: {autoNumber: "AMS"}, //수식번호 옵션
                extensions: ["cancel.js","color.js"], //캔슬링 추가
                    TagSide: "left" //자동 넘버링 왼쪽으로되는 설정
    }//displayAlign: "left" 디스플레이 모드도 왼쪽정렬
                
});
</script> -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        renderMathInElement(document.body, {
          // customised options
          // • auto-render specific keys, e.g.:
          delimiters: [
              {left: '$$', right: '$$', display: true},
              {left: '$', right: '$', display: false},
          ],
		  trust: ["\\htmlId"],
		  macros: {
		  "\\eqref": "\\href{###1}{(\\text{#1})}",
		  "\\ref": "\\href{###1}{\\text{#1}}",
		  "\\label": "\\htmlId{#1}{}"
		  },
          // • rendering keys, e.g.:
          throwOnError : false
        });
    });
</script>
</body>
</html>