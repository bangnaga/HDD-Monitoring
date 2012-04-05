#!/usr/bin/python

import psutil
import json
partitions = psutil.disk_partitions()
for partition in partitions :
  device = partition.device
  mount =  partition.mountpoint
  filesystype = partition.fstype
  if(mount == "/") :
    check_slash = psutil.disk_usage(mount)
    check_slash_json = json.dumps({'mount on':mount, 'total':check_slash.total, 'used':check_slash.used, 'free':check_slash.free, 'percent':check_slash.percent, 'filetype':filesystype, 'device':device})
    print check_slash_json
  else :
    check_slash_home = psutil.disk_usage("/home")
    check_slash_home_json = json.dumps({'mount on':mount, 'total':check_slash_home.total, 'used':check_slash_home.used, 'free':check_slash_home.free, 'percent':check_slash_home.percent,  'filetype':filesystype, 'device':device})
    print check_slash_home_json
