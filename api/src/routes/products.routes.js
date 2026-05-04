/**
 * @openapi
 * tags:
 *   - name: Products
 *     description: Catàleg de pel·lícules (LostTapes)
 *
 * /api/v1/products:
 *   get:
 *     summary: Llistar productes
 *     tags: [Products]
 *     responses:
 *       200:
 *         description: Llista de productes
 *
 *   post:
 *     summary: Crear producte
 *     tags: [Products]
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           example:
 *             sku: "SKU030"
 *             name: "La pasión de Juana de Arco"
 *             description: "Obra maestra silente..."
 *             price: 22.99
 *             stock: 26
 *             image: "joanArc.jpg"
 *             category: "pelicula"
 *     responses:
 *       201:
 *         description: Producte creat
 *       422:
 *         description: Error de validació
 *
 * /api/v1/products/{id}:
 *   get:
 *     summary: Obtenir producte per ID
 *     tags: [Products]
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema:
 *           type: string
 *     responses:
 *       200:
 *         description: Producte trobat
 *       404:
 *         description: No trobat
 *
 *   put:
 *     summary: Actualitzar producte
 *     tags: [Products]
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema:
 *           type: string
 *     requestBody:
 *       required: true
 *       content:
 *         application/json:
 *           example:
 *             name: "Juana de Arco (Restaurada)"
 *             price: 25.99
 *     responses:
 *       200:
 *         description: Actualitzat
 *       404:
 *         description: No trobat
 *       422:
 *         description: Error de validació
 *
 *   delete:
 *     summary: Esborrar producte
 *     tags: [Products]
 *     parameters:
 *       - in: path
 *         name: id
 *         required: true
 *         schema:
 *           type: string
 *     responses:
 *       204:
 *         description: Eliminat
 *       404:
 *         description: No trobat
 */
import { Router } from 'express';
import { validationResult } from 'express-validator';
import * as controller from '../controllers/products.controller.js';
import { productCreateRules, productUpdateRules } from '../validation/products.rules.js';

const router = Router();

const validate = (rules) => [
  ...rules,
  (req, res, next) => {
    const result = validationResult(req);
    if (!result.isEmpty()) {
      return res.status(422).json({ errors: result.array() });
    }
    next();
  }
];

router.get('/', controller.list);
router.get('/:id', controller.getById);
router.post('/', validate(productCreateRules), controller.create);
router.put('/:id', validate(productUpdateRules), controller.update);
router.delete('/:id', controller.remove);

export default router;