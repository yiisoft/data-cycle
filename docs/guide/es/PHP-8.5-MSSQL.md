Implicaciones de PHP 8.5 para el Flujo de Trabajo de MSSQL (Fuente IA: Claude Sonnet 4.5 - prueba gratuita)
Resumen Ejecutivo
No agregue PHP 8.5 al flujo de trabajo de MSSQL todavía. El controlador pdo_sqlsrv actual (versión 5.12) no es compatible con PHP 8.5, y el flujo de trabajo fallará durante la instalación de extensiones de PHP.
Bloqueador Crítico: Incompatibilidad del Controlador
Situación Actual
La extensión pdo_sqlsrv 5.12.0 especificada en el flujo de trabajo no se compila con PHP 8.5.0 debido a cambios internos en la API de PHP. Esto significa que cualquier intento de agregar PHP 8.5 a la matriz de pruebas resultará en fallas inmediatas del flujo de trabajo.
Estado de Compatibilidad del Controlador
Versión de PHPCompatibilidad pdo_sqlsrv 5.128.1✅ Totalmente Compatible8.2✅ Totalmente Compatible8.3✅ Totalmente Compatible8.4⚠️ No Oficial/Limitado8.5❌ No Compatible
Qué Debe Suceder Primero
Antes de que PHP 8.5 pueda agregarse al flujo de trabajo:

Microsoft debe lanzar una nueva versión del controlador pdo_sqlsrv (probablemente 5.13 o 6.0)
El nuevo controlador debe estar disponible a través de PECL para instalación mediante shivammathur/setup-php
La configuración de extensiones del flujo de trabajo debe actualizarse para hacer referencia a la nueva versión del controlador

Expectativas de Cronograma
Basado en patrones históricos con versiones anteriores de PHP:

Retraso esperado: 2-6 meses después del lanzamiento oficial de PHP 8.5
Precedente de PHP 8.4: A finales de 2024/principios de 2025, PHP 8.4 todavía carece de soporte oficial completo del controlador MSSQL
Recomendación: Monitorear el repositorio msphpsql de Microsoft para anuncios

Plan de Acción Recomendado
Fase 1: Monitoreo (Actual)
Monitorear estos recursos para actualizaciones:

GitHub msphpsql de Microsoft - Repositorio oficial del controlador
Página PECL pdo_sqlsrv - Anuncios de lanzamiento
Notas de lanzamiento de PHP 8.5 y matrices de compatibilidad

Fase 2: Pruebas Tempranas (Cuando el Controlador Esté Disponible)
Una vez que se lance un controlador compatible:
yamlstrategy:
  matrix:
    php:
      - 8.1
      - 8.2
      - 8.3
      - 8.4
      - 8.5
Actualizar la configuración de extensiones:
yamlenv:
  extensions: pdo, pdo_sqlsrv-5.13  # O la nueva versión que sea
Considerar usar continue-on-error: true inicialmente para trabajos de PHP 8.5:
yaml- name: Run tests with phpunit
  continue-on-error: ${{ matrix.php == '8.5' }}
  run: vendor/bin/phpunit --testsuite=Mssql --coverage-clover=coverage.xml
       --colors=always
```

### Fase 3: Integración Completa

Después de confirmar la estabilidad:

- Eliminar la bandera `continue-on-error`
- Hacer de PHP 8.5 una prueba requerida en el pipeline de CI

## Puntos de Falla Potenciales

Si agrega PHP 8.5 prematuramente, espere fallas en:

1. **Paso de Instalación de Extensión**
```
   shivammathur/setup-php@v2
Error: No se puede instalar pdo_sqlsrv-5.12 para PHP 8.5

Errores de Compilación
El controlador puede intentar compilar pero fallar debido a incompatibilidades de API
Errores en Tiempo de Ejecución
Incluso si la instalación tiene éxito, las incompatibilidades en tiempo de ejecución pueden causar fallas en las pruebas

Características de PHP 8.5 a Tener en Cuenta
Mientras espera el soporte del controlador, tenga en cuenta estos cambios de PHP 8.5 que podrían impactar su código base:

Operador pipe: Nueva sintaxis de programación funcional
Sintaxis clone with: Clonación de objetos mejorada
Deprecaciones: Conversiones de tipo escalar no canónicas
Otras mejoras: Hooks de propiedades, visibilidad asimétrica

Estos cambios probablemente no afectarán directamente las operaciones de base de datos, pero pueden impactar el código de la aplicación.
Estrategia de Pruebas
Cuando el soporte del controlador esté disponible:

Crear una rama de prueba separada con PHP 8.5 agregado a la matriz
Ejecutar el conjunto completo de pruebas contra todas las versiones de MSSQL (2017, 2019, 2022)
Verificar advertencias de deprecación en la salida de pruebas
Verificar compatibilidad con todas las versiones de PHP en la matriz
Monitorear regresiones de rendimiento

Estado Actual del Flujo de Trabajo
El flujo de trabajo actualmente prueba:

Versiones de PHP: 8.1, 8.2, 8.3, 8.4
Versiones de MSSQL: 2017 (ODBC 17), 2019 (ODBC 18), 2022 (ODBC 18)
Versión del controlador: pdo_sqlsrv-5.12

Esta configuración es estable y debe permanecer sin cambios hasta que se confirme la compatibilidad del controlador.
Conclusión
Acción Requerida: Ninguna en este momento. Continuar monitoreando para actualizaciones del controlador pdo_sqlsrv.
No Hacer: Agregar PHP 8.5 a la matriz de pruebas hasta que Microsoft lance una versión compatible del controlador.
Próximos Pasos: Vigilar el repositorio GitHub msphpsql de Microsoft para anuncios de lanzamiento y actualizar este documento cuando nueva información esté disponible.

Última Actualización: 21 de enero de 2026
Estado: Esperando soporte del controlador pdo_sqlsrv para PHP 8.5
¿También se puede actualizar Actions checkout a la versión 6?
Novedades en v6
La versión 6 incluye soporte para Node.js 24 y persiste credenciales en un archivo PHP separado, junto con mejoras en el soporte de worktree.
Ruta de Actualización
Puede actualizar de manera segura de v3 → v4 → v5 → v6, o saltar directamente a v6. La acción mantiene compatibilidad hacia atrás para uso básico.
Flujo de Trabajo Actualizado
Aquí está su flujo de trabajo con la acción checkout actualizada a v6:
yaml- name: Checkout
uses: actions/checkout@v4  # Puede actualizarse a @v6
Debe convertirse en:
yaml- name: Checkout
uses: actions/checkout@v6
¿Debería Actualizar?
Sí, debería actualizar por varias razones:
Actualizaciones de seguridad - Las versiones más nuevas incluyen parches de seguridad
Soporte para Node.js 24 - Mejor rendimiento y compatibilidad
Corrección de errores - Varias mejoras y mejoras de estabilidad
Preparación para el futuro - v3 es bastante antigua y eventualmente puede quedar obsoleta
Consideraciones de Migración
La actualización de v3 a v6 debería ser sin problemas para su caso de uso, ya que está usando el checkout básico sin parámetros especiales.
Sin embargo, es una buena práctica:

Probar el flujo de trabajo en una rama de características primero
Revisar el registro de cambios para cualquier cambio importante
Considerar fijar a un SHA de commit específico para máxima estabilidad en producción (por ejemplo, actions/checkout@8e8c483db84b4bee98b60c0593521ed34d9990e8)

¡Para su flujo de trabajo, la simple actualización de versión está perfectamente bien y es recomendada!
