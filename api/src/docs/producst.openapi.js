 /**
 * @openapi
 * components:
 *   schemas:
 *     Product:
 *       type: object
 *       properties:
 *         _id:
 *           type: string
 *           example: "64f1a2b3c4d5e6f7a8b9c0d1"
 *         sku:
 *           type: string
 *           pattern: '^[A-Z0-9-]+$'
 *           example: "SKU030"
 *         name:
 *           type: string
 *           minLength: 2
 *           example: "La pasión de Juana de Arco"
 *         description:
 *           type: string
 *           example: "Obra maestra silente de Dreyer con restauración completa"
 *         price:
 *           type: number
 *           minimum: 0
 *           example: 22.99
 *         stock:
 *           type: integer
 *           minimum: 0
 *           example: 26
 *         image:
 *           type: string
 *           example: "joanArc.jpg"
 *         category:
 *           type: string
 *           enum: [pelicula, serie, documental]
 *           example: "pelicula"
 *         createdAt:
 *           type: string
 *           format: date-time
 *         updatedAt:
 *           type: string
 *           format: date-time
 *
 *     ProductCreate:
 *       type: object
 *       required:
 *         - sku
 *         - name
 *         - description
 *         - price
 *         - stock
 *         - category
 *       properties:
 *         sku:
 *           type: string
 *           example: "SKU030"
 *         name:
 *           type: string
 *           example: "La pasión de Juana de Arco"
 *         description:
 *           type: string
 *           example: "Obra maestra silente de Dreyer"
 *         price:
 *           type: number
 *           example: 22.99
 *         stock:
 *           type: integer
 *           example: 26
 *         image:
 *           type: string
 *           example: "joanArc.jpg"
 *         category:
 *           type: string
 *           enum: [pelicula, serie, documental]
 *
 *     ProductUpdate:
 *       type: object
 *       properties:
 *         sku:
 *           type: string
 *           example: "SKU031"
 *         name:
 *           type: string
 *         description:
 *           type: string
 *         price:
 *           type: number
 *         stock:
 *           type: integer
 *         image:
 *           type: string
 *         category:
 *           type: string
 *           enum: [pelicula, serie, documental]
 *
 *     Error:
 *       type: object
 *       properties:
 *         error:
 *           type: string
 *           example: "SKU duplicat"
 *         errors:
 *           type: array
 *           items:
 *             type: object
 */