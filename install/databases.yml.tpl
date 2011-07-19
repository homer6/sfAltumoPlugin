# You can find more information about this file on the symfony website:
# http://www.symfony-project.org/reference/1_4/en/07-Databases

dev:
  propel:
    param:
      classname:  DebugPDO
      debug:
        realmemoryusage: true
        details:
          time:       { enabled: true }
          slow:       { enabled: true, threshold: 0.1 }
          mem:        { enabled: true }
          mempeak:    { enabled: true }
          memdelta:   { enabled: true }

test:
  propel:
    param:
      classname:  DebugPDO

all:
  propel:
    class:        sfPropelDatabase
    param:
      classname:  PropelPDO
      dsn:        mysql:dbname=[[DATABASE]];host=[[DATABASE_HOST]]
      username:   [[DATABASE_USER]]
      password:   [[DATABASE_PASSWORD]]
      encoding:   utf8
      persistent: true
      pooling:    true
