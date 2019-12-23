---
layout: article
title: Test coverage using Google Test, GCov and LCov
tags:
  - softwaredevelopment
author:
  name: Rafael Cavalcanti
  url: /profile/rafaelcavalcanti/
licence: cc_attrib
---

This post will describe a setup to start working with test coverage. First of all, I would like to highlight the GitHub link of this project [BraveCoverage](https://github.com/dr-kino/BraveCoverage)

It is related to a very small piece of code to demonstrate how to start a project providing test coverage metrics. But for what it is important? In resume, there are many motives to do that but I like to concentrante in one: The Quality of Your Job. When you provide unit tests for your code it means that you are a person concerned about the quality of your delivered work and want to improve your skills, for instance. And the way to know if you are testing all the lines is through code coverage tool.

The tool chosen to execute code coverage is [gcov](https://linux.die.net/man/1/gcov), with this tool you will be able to know how many times the lines of your program was executed and if there are lines non executed by your tests cases. You can see the results provided by the gcov in the next image, basically it shows the total of line in your program and the lines runned by the test program, note highlighted in green all line tested and you can see also that some lines regarding to library have included in analysis.

<img src="/images/posts/00005-E.png" />

Class declaration:
``` 
class Sum
{
public:
    Sum() { };
    ~Sum() { };

    void setAValue(int A);
    void setBValue(int B);
    int executeSum(void);

private:
    int _A = 0;
    int _B = 0;
};
```

Methods definition:
```
void Sum::setAValue(int A) {
    _A = A;
}

void Sum::setBValue(int B) {
    _B = B;
}

int Sum::executeSum(void) {
    return _A + _B;
}
```

Test case:
```
TEST(BraveCoverage, TestCaseOne) {
    Sum SumUnderTest;
    SumUnderTest.setAValue(10);
    SumUnderTest.setBValue(10);

    EXPECT_EQ(20, SumUnderTest.executeSum());
}
```

CMakeLists.txt (make gcov):
```
add_custom_command(TARGET gcov
    COMMAND echo "=================== GCOV ===================="
    COMMAND gcov -b ${CMAKE_SOURCE_DIR}/src/*.cpp -o ${OBJECT_DIR}
    COMMAND echo "-- Source diretorie: ${CMAKE_SOURCE_DIR}/src/"
    COMMAND echo "-- Coverage files have been output to ${CMAKE_BINARY_DIR}/gcoverage"
    WORKING_DIRECTORY ${CMAKE_BINARY_DIR}/gcoverage
    COMMAND echo "-- Passing lcov tool under code coverage"
    COMMAND lcov --capture --directory ../ --output-file main_coverage.info
    COMMAND echo "-- Generating HTML output files"
    COMMAND genhtml main_coverage.info --output-directory out
    )
```

CMakeLists.txt (make lcov):
```
add_custom_command(TARGET lcov
    COMMAND echo "=================== LCOV ===================="
    COMMAND echo "-- Passing lcov tool under code coverage"
    COMMAND lcov --capture --directory ../ --output-file lcoverage/main_coverage.info
    COMMAND echo "-- Generating HTML output files"
    COMMAND genhtml lcoverage/main_coverage.info --output-directory lcoverage
    )
```

<img src="/images/posts/00005-A.png" />

<img src="/images/posts/00005-C.png" />

<img src="/images/posts/00005-B.png" />

<img src="/images/posts/00005-D.png" />
