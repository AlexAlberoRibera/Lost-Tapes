import path from 'node:path';
import { fileURLToPath } from 'node:url';
import swaggerJSDoc from 'swagger-jsdoc';

const __dirname = path.dirname(fileURLToPath(import.meta.url));

const apis = [
  path.resolve(__dirname, 'routes/*.js'),
  path.resolve(__dirname, 'docs/products.openapi.js')
];

export const swaggerSpec = swaggerJSDoc({
  definition: {
    openapi: '3.0.3',
    info: { title: 'API Inventari', version: '1.0.0' },
    servers: [{ url: 'http://localhost:3000' }],

    components: {
      securitySchemes: {
        bearerAuth: {
          type: 'http',
          scheme: 'bearer',
          bearerFormat: 'JWT'
        }
      },
      schemas: {
        Product: {
          type: 'object',
          properties: {
            _id: { type: 'string' },
            name: { type: 'string' },
            sku: { type: 'string' },
            price: { type: 'number' },
            stock: { type: 'integer' },
            active: { type: 'boolean' }
          }
        },
    
        ProductCreate: {
          type: 'object',
          required: ['name', 'sku', 'price'],
          properties: {
            name: { type: 'string' },
            sku: { type: 'string' },
            price: { type: 'number' },
            stock: { type: 'integer' }
          }
        },
    
        ProductUpdate: {
          type: 'object',
          properties: {
            name: { type: 'string' },
            sku: { type: 'string' },
            price: { type: 'number' },
            stock: { type: 'integer' },
            active: { type: 'boolean' }
          }
        },      
      }
    },
    security: [{ bearerAuth: [] }]
  },

  apis: [
    path.resolve(__dirname, 'routes/*.js'),
    path.resolve(__dirname, 'docs/*.js')
  ]
});