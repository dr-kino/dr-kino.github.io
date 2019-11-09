---
layout: article
title: Base project to use gtest and gmock for unit tests
tags:
  - softwaredevelopment
  - embeddedsystems
author:
  name: Rafael Cavalcanti
  url: /profile/rafaelcavalcanti/
licence: cc_attrib
---

The goal of this post is to create a base to be used in all unit tests project that uses google test and google mock framework. Here I am configuring the environment for a Debian distribution and, of course, the commands below is valid only for distribution Debian based. So, first thing first, we need to install all dependencies as following:

```
#apt-get install libgtest-dev
#apt-get install google-mock
#apt-get install libgmock-dev
```

After installation, we can create three files: CMakeLists.txt, Main.cpp and UnitUnderTest.cpp. These files will be the base for our project and below we can see the content of each one.

CMakeLists.txt
```
cmake_minimum_required(VERSION 2.6)

include_directories(/usr/include)
link_directories(/usr/lib)

set(CMAKE_CXX_FLAGS "${CMAKE_CXX_FLAGS} -Wall")

find_package(GTest REQUIRED)
include_directories(${GTEST_INCLUDE_DIRS})

set(sources
		Main.cpp
		UnitUnderTest.cpp
		)

add_executable(UnitTests ${sources})

target_link_libraries(UnitTests gtest)
target_link_libraries(UnitTests gmock)
target_link_libraries(UnitTests pthread)
```

Main.cpp
```c++
#include "gmock/gmock.h"

int main(int argc, char** argv) {
	::testing::InitGoogleMock(&argc, argv);
	return RUN_ALL_TESTS();
}
```

UnitUnderTest.cpp
```c++
#include "gmock/gmock.h"

TEST(Test_UnitUnderTest, TestCaseOne) {

}
```

After the build, commands "cmake .." and "make", the output below can be seen running ./UnitTests.

```
[==========] Running 1 test from 1 test case.
[----------] Global test environment set-up.
[----------] 1 test from Test_UnitUnderTest
[ RUN      ] Test_UnitUnderTest.TestCaseOne
[       OK ] Test_UnitUnderTest.TestCaseOne (0 ms)
[----------] 1 test from Test_UnitUnderTest (0 ms total)

[----------] Global test environment tear-down
[==========] 1 test from 1 test case ran. (0 ms total)
[  PASSED  ] 1 test.
```
