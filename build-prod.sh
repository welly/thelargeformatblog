#!/bin/bash

mkdir /tmp/${BUILD_TIMESTAMP}
cp -R . /tmp/${BUILD_TIMESTAMP}
cd /tmp
rm -rf ${BUILD_TIMESTAMP}/.git
tar chzf /tmp/${BUILD_TIMESTAMP}.tar.gz ${BUILD_TIMESTAMP}
rm -rf /tmp/${BUILD_TIMESTAMP}
scp /tmp/${BUILD_TIMESTAMP}.tar.gz www-data@skywalker:/tmp
